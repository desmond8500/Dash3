<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Str;
use RuntimeException;

/**
 * Conversion DWG → PDF en deux temps :
 *   1. DWG → DXF avec LibreDWG (dwg2dxf) ou ODA File Converter
 *   2. DXF → PDF avec ezdxf (ezdxf draw -o plan.pdf plan.dxf)
 * Les outils sont configurés dans config/plans.php.
 */
class DwgConverter
{
    /**
     * Convertit $dwgPath (chemin absolu) en PDF à $pdfPath (chemin absolu).
     *
     * @throws RuntimeException si un outil manque ou échoue
     */
    public function toPdf(string $dwgPath, string $pdfPath): void
    {
        if (! is_file($dwgPath)) {
            throw new RuntimeException("Fichier DWG introuvable : $dwgPath");
        }

        $work = storage_path('app/dwg-convert/' . Str::random(12));
        File::ensureDirectoryExists($work);

        try {
            $dxf = $this->toDxf($dwgPath, $work);
            File::ensureDirectoryExists(dirname($pdfPath));
            $this->run([config('plans.ezdxf_bin'), 'draw', '-o', $pdfPath, $dxf], 'ezdxf (DXF → PDF)');

            if (! is_file($pdfPath) || filesize($pdfPath) === 0) {
                throw new RuntimeException("ezdxf n'a produit aucun PDF");
            }
        } finally {
            File::deleteDirectory($work);
        }
    }

    /** Étape 1 : DWG → DXF dans le dossier de travail ; renvoie le chemin du DXF */
    private function toDxf(string $dwgPath, string $work): string
    {
        $dxf = $work . '/plan.dxf';

        if (config('plans.dwg_driver') === 'oda') {
            // ODAFileConverter <dossier source> <dossier cible> <version> <type> <récursif> <audit> [filtre]
            $in = $work . '/in';
            $out = $work . '/out';
            File::ensureDirectoryExists($in);
            File::ensureDirectoryExists($out);
            File::copy($dwgPath, $in . '/plan.dwg');
            $this->run([config('plans.oda_bin'), $in, $out, config('plans.oda_dxf_version'), 'DXF', '0', '1', '*.DWG'], 'ODA File Converter (DWG → DXF)');
            $produced = collect(File::files($out))->first(fn ($f) => strtolower($f->getExtension()) === 'dxf');
            if (! $produced) {
                throw new RuntimeException("ODA File Converter n'a produit aucun DXF");
            }
            File::move($produced->getPathname(), $dxf);
        } else {
            // LibreDWG : dwg2dxf -y (écraser) -o <sortie> <entrée>
            $this->run([config('plans.dwg2dxf_bin'), '-y', '-o', $dxf, $dwgPath], 'LibreDWG dwg2dxf (DWG → DXF)');
        }

        if (! is_file($dxf)) {
            throw new RuntimeException("La conversion DWG → DXF n'a produit aucun fichier");
        }

        return $dxf;
    }

    private function run(array $command, string $label): void
    {
        $result = Process::timeout(config('plans.timeout'))->run($command);

        if ($result->failed()) {
            $output = trim($result->errorOutput() ?: $result->output());
            $hint = str_contains($output, 'not found') || $result->exitCode() === 127
                ? ' — outil introuvable : vérifiez l\'installation et config/plans.php'
                : '';
            throw new RuntimeException("$label a échoué (code {$result->exitCode()})$hint : " . Str::limit($output, 500));
        }
    }

    /** Vérifie la présence des outils (pour la commande plans:check) */
    public function check(): array
    {
        $tools = config('plans.dwg_driver') === 'oda'
            ? ['ODA File Converter' => [config('plans.oda_bin')]]
            : ['LibreDWG dwg2dxf' => [config('plans.dwg2dxf_bin'), '--version']];
        $tools['ezdxf'] = [config('plans.ezdxf_bin'), '--version'];

        $report = [];
        foreach ($tools as $name => $cmd) {
            try {
                $r = Process::timeout(20)->run($cmd);
                $report[$name] = $r->successful() ? ('OK ' . trim(strtok($r->output() ?: $r->errorOutput(), "\n"))) : 'ERREUR : ' . trim($r->errorOutput());
            } catch (\Throwable $e) {
                $report[$name] = 'ERREUR : ' . $e->getMessage();
            }
        }

        return $report;
    }
}
