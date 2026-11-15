<?php

namespace App\Console\Commands;

use App\Jobs\ConvertDwgPlan;
use App\Models\Plan;
use App\Services\DwgConverter;
use Illuminate\Console\Command;

/** php artisan plans:convert [id] [--check] [--failed] */
class PlansConvert extends Command
{
    protected $signature = 'plans:convert
        {id? : Identifiant du plan (sinon tous les DWG non convertis)}
        {--check : Vérifier seulement la présence des outils de conversion}
        {--failed : Relancer aussi les conversions en échec}';

    protected $description = 'Convertit les plans DWG en PDF (LibreDWG / ODA + ezdxf)';

    public function handle(DwgConverter $converter): int
    {
        if ($this->option('check')) {
            foreach ($converter->check() as $tool => $state) {
                $this->line(str_pad($tool, 22) . ' ' . $state);
            }
            return self::SUCCESS;
        }

        $plans = Plan::where('kind', 'dwg')
            ->when($this->argument('id'), fn ($q, $id) => $q->whereKey($id))
            ->when(! $this->argument('id'), function ($q) {
                $q->where(function ($q) {
                    $q->whereNull('conversion_status')->orWhereIn('conversion_status', $this->option('failed') ? ['pending', 'failed'] : ['pending']);
                });
            })
            ->get();

        if ($plans->isEmpty()) {
            $this->info('Aucun plan DWG à convertir.');
            return self::SUCCESS;
        }

        foreach ($plans as $plan) {
            $this->line("Plan {$plan->id} « {$plan->name} »…");
            ConvertDwgPlan::dispatchSync($plan->id);
            $plan->refresh();
            $plan->conversion_status === 'done'
                ? $this->info("  converti : {$plan->converted_file}")
                : $this->error("  échec : {$plan->conversion_error}");
        }

        return self::SUCCESS;
    }
}
