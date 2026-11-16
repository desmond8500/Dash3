<?php

namespace App\Services;

use Intervention\Image\Direction;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use InvalidArgumentException;

/**
 * Édition des images stockées sur le disque « public » (storage/app/public) :
 * pivoter, retourner, rogner, redimensionner.
 *
 * Ordre d'application (identique à l'éditeur du front web) :
 *   1. orientation EXIF (comme le navigateur l'affiche)
 *   2. rotation (multiple de 90°, sens horaire)
 *   3. retournement horizontal / vertical
 *   4. rognage — coordonnées en pixels de l'image après 1-3
 *   5. redimensionnement
 */
class ImageEditor
{
    public const EXTENSIONS = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'bmp', 'avif'];

    /** Côté maximal accepté pour un redimensionnement */
    public const MAX_SIDE = 8000;

    private ImageManager $manager;

    /**
     * @param  string  $root  dossier racine du disque public (Storage::disk('public')->path(''))
     */
    public function __construct(private string $root)
    {
        $this->root = rtrim($root, '/\\');
        $this->manager = new ImageManager(new Driver());
    }

    /**
     * Ramène ce que le front connaît d'une image à un chemin relatif au disque public.
     * Accepte : URL complète (https://…/storage/a/b.png?v=1), « storage/a/b.png », « /storage/a/b.png », « a/b.png ».
     * Refuse tout ce qui sort du disque public ou n'est pas une image.
     *
     * @throws InvalidArgumentException
     */
    public function resolve(string $input): string
    {
        $path = trim($input);
        if (preg_match('#^https?://#i', $path)) {
            $path = (string) parse_url($path, PHP_URL_PATH);
        }
        $path = strtok($path, '?#') ?: '';
        $path = rawurldecode($path);
        $path = str_replace('\\', '/', $path);

        // Tout ce qui suit le premier « /storage/ » (ou « storage/ » en tête)
        if (($pos = strpos($path, '/storage/')) !== false) {
            $path = substr($path, $pos + strlen('/storage/'));
        } elseif (str_starts_with($path, 'storage/')) {
            $path = substr($path, strlen('storage/'));
        }
        $path = ltrim($path, '/');

        if ($path === '' || str_contains($path, "\0")) {
            throw new InvalidArgumentException('Chemin d\'image invalide');
        }
        foreach (explode('/', $path) as $segment) {
            if ($segment === '..' || $segment === '.') {
                throw new InvalidArgumentException('Chemin d\'image invalide');
            }
        }
        if (! in_array(strtolower(pathinfo($path, PATHINFO_EXTENSION)), self::EXTENSIONS, true)) {
            throw new InvalidArgumentException('Ce fichier n\'est pas une image modifiable');
        }

        $absolute = $this->absolute($path);
        $real = realpath($absolute);
        $rootReal = realpath($this->root);
        if ($real === false || ! is_file($real)) {
            throw new InvalidArgumentException('Image introuvable');
        }
        // Lien symbolique ou autre détour qui sortirait du disque public
        if ($rootReal === false || ! str_starts_with($real, $rootReal . DIRECTORY_SEPARATOR)) {
            throw new InvalidArgumentException('Chemin d\'image invalide');
        }

        return $path;
    }

    /** Dimensions et poids d'une image (chemin relatif déjà résolu). */
    public function info(string $path): array
    {
        $absolute = $this->absolute($path);
        $image = $this->manager->decodePath($absolute)->orient();

        return [
            'path' => $path,
            'width' => $image->width(),
            'height' => $image->height(),
            'size' => filesize($absolute),
            'version' => filemtime($absolute),
        ];
    }

    /**
     * Applique les opérations et enregistre le résultat.
     *
     * @param  array{rotate?:int, flip_h?:bool, flip_v?:bool, crop?:?array{x:int,y:int,width:int,height:int}, resize?:?array{width?:?int,height?:?int}, quality?:int}  $ops
     * @param  bool  $copy  true : nouveau fichier à côté de l'original ; false : remplace l'original
     * @return array{path:string, width:int, height:int, size:int, version:int}
     *
     * @throws InvalidArgumentException
     */
    public function edit(string $path, array $ops, bool $copy = false): array
    {
        $source = $this->absolute($path);
        $image = $this->manager->decodePath($source)->orient();

        $rotate = (int) ($ops['rotate'] ?? 0);
        if ($rotate % 90 !== 0) {
            throw new InvalidArgumentException('La rotation doit être un multiple de 90°');
        }
        $rotate = (($rotate % 360) + 360) % 360;
        if ($rotate !== 0) {
            $image->rotate($rotate); // positif = sens horaire avec Intervention v4
        }

        if (! empty($ops['flip_h'])) {
            $image->flip(Direction::HORIZONTAL);
        }
        if (! empty($ops['flip_v'])) {
            $image->flip(Direction::VERTICAL);
        }

        if (! empty($ops['crop'])) {
            [$x, $y, $w, $h] = $this->clampCrop($ops['crop'], $image->width(), $image->height());
            if ($x !== 0 || $y !== 0 || $w !== $image->width() || $h !== $image->height()) {
                $image->crop($w, $h, $x, $y);
            }
        }

        $resize = $ops['resize'] ?? null;
        $rw = isset($resize['width']) && $resize['width'] !== '' ? (int) $resize['width'] : null;
        $rh = isset($resize['height']) && $resize['height'] !== '' ? (int) $resize['height'] : null;
        if ($rw !== null || $rh !== null) {
            foreach ([$rw, $rh] as $side) {
                if ($side !== null && ($side < 1 || $side > self::MAX_SIDE)) {
                    throw new InvalidArgumentException('Dimension de redimensionnement invalide (1 à ' . self::MAX_SIDE . ' px)');
                }
            }
            if ($rw !== null && $rh !== null) {
                $image->resize($rw, $rh);   // dimensions exactes
            } else {
                $image->scale($rw, $rh);    // un seul côté : proportions conservées
            }
        }

        $target = $copy ? $this->copyPath($path) : $path;
        $quality = max(10, min(100, (int) ($ops['quality'] ?? 90)));
        $image->save($this->absolute($target), quality: $quality);
        clearstatcache(true, $this->absolute($target));

        return [
            'path' => $target,
            'width' => $image->width(),
            'height' => $image->height(),
            'size' => filesize($this->absolute($target)),
            'version' => filemtime($this->absolute($target)),
        ];
    }

    /** Limite la zone de rognage à l'image. @return array{0:int,1:int,2:int,3:int} */
    private function clampCrop(array $crop, int $imgW, int $imgH): array
    {
        $x = max(0, (int) round($crop['x'] ?? 0));
        $y = max(0, (int) round($crop['y'] ?? 0));
        $w = (int) round($crop['width'] ?? 0);
        $h = (int) round($crop['height'] ?? 0);
        if ($x >= $imgW || $y >= $imgH) {
            throw new InvalidArgumentException('Zone de rognage hors de l\'image');
        }
        $w = min($w, $imgW - $x);
        $h = min($h, $imgH - $y);
        if ($w < 1 || $h < 1) {
            throw new InvalidArgumentException('Zone de rognage vide');
        }

        return [$x, $y, $w, $h];
    }

    /** « dossier/photo.jpg » → « dossier/photo-edit-20261116-180102.jpg » (sans écraser l'existant) */
    private function copyPath(string $path): string
    {
        $info = pathinfo($path);
        $dir = ($info['dirname'] ?? '.') === '.' ? '' : $info['dirname'] . '/';
        $base = preg_replace('/-edit-\d{8}-\d{6}(-\d+)?$/', '', $info['filename']);
        $ext = $info['extension'] ?? 'jpg';
        $stamp = date('Ymd-His');

        $candidate = "{$dir}{$base}-edit-{$stamp}.{$ext}";
        for ($i = 2; is_file($this->absolute($candidate)); $i++) {
            $candidate = "{$dir}{$base}-edit-{$stamp}-{$i}.{$ext}";
        }

        return $candidate;
    }

    private function absolute(string $path): string
    {
        return $this->root . '/' . ltrim($path, '/');
    }
}
