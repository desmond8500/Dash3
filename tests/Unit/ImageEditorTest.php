<?php

namespace Tests\Unit;

use App\Services\ImageEditor;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Service d'édition d'images (sans base de données ni Laravel).
 * Image de test : 400×200, moitié gauche rouge, moitié droite bleue.
 */
class ImageEditorTest extends TestCase
{
    private string $root;

    private ImageEditor $editor;

    protected function setUp(): void
    {
        if (! extension_loaded('gd')) {
            $this->markTestSkipped('Extension GD absente');
        }
        $this->root = sys_get_temp_dir() . '/image-editor-' . uniqid();
        mkdir($this->root . '/stock/articles/1/images', 0777, true);

        $im = imagecreatetruecolor(400, 200);
        imagefilledrectangle($im, 0, 0, 199, 199, imagecolorallocate($im, 255, 0, 0));
        imagefilledrectangle($im, 200, 0, 399, 199, imagecolorallocate($im, 0, 0, 255));
        imagepng($im, $this->root . '/stock/articles/1/images/photo.png');

        $this->editor = new ImageEditor($this->root);
    }

    protected function tearDown(): void
    {
        if (isset($this->root) && is_dir($this->root)) {
            exec('rm -rf ' . escapeshellarg($this->root));
        }
    }

    private function color(string $path, int $x, int $y): string
    {
        $im = imagecreatefromstring(file_get_contents($this->root . '/' . $path));
        $c = imagecolorat($im, $x, $y);

        return sprintf('%02x%02x%02x', ($c >> 16) & 255, ($c >> 8) & 255, $c & 255);
    }

    public static function acceptedPaths(): array
    {
        return [
            'URL complète' => ['https://dash3.yonkou.info/storage/stock/articles/1/images/photo.png?v=12'],
            'storage/…' => ['storage/stock/articles/1/images/photo.png'],
            '/storage/…' => ['/storage/stock/articles/1/images/photo.png'],
            'relatif' => ['stock/articles/1/images/photo.png'],
        ];
    }

    #[DataProvider('acceptedPaths')]
    public function test_resolve_accepte_les_formes_connues_du_front(string $input): void
    {
        $this->assertSame('stock/articles/1/images/photo.png', $this->editor->resolve($input));
    }

    public static function refusedPaths(): array
    {
        return [
            'remontée' => ['../../etc/passwd.png'],
            'remontée dans storage' => ['storage/../photo.png'],
            'pas une image' => ['stock/articles/1/images/script.php'],
            'introuvable' => ['stock/articles/1/images/absent.png'],
        ];
    }

    #[DataProvider('refusedPaths')]
    public function test_resolve_refuse_les_chemins_dangereux(string $input): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->editor->resolve($input);
    }

    public function test_rotation_horaire(): void
    {
        $r = $this->editor->edit('stock/articles/1/images/photo.png', ['rotate' => 90], copy: true);

        $this->assertSame([200, 400], [$r['width'], $r['height']]);
        $this->assertSame('ff0000', $this->color($r['path'], 100, 10));   // le rouge (gauche) passe en haut
        $this->assertSame('0000ff', $this->color($r['path'], 100, 390));
    }

    public function test_retournement_horizontal(): void
    {
        $r = $this->editor->edit('stock/articles/1/images/photo.png', ['flip_h' => true], copy: true);

        $this->assertSame('0000ff', $this->color($r['path'], 10, 100));
    }

    public function test_rognage_et_limite_aux_bords(): void
    {
        $r = $this->editor->edit('stock/articles/1/images/photo.png', ['crop' => ['x' => 220, 'y' => 50, 'width' => 150, 'height' => 100]], copy: true);
        $this->assertSame([150, 100], [$r['width'], $r['height']]);
        $this->assertSame('0000ff', $this->color($r['path'], 5, 5));

        $r = $this->editor->edit('stock/articles/1/images/photo.png', ['crop' => ['x' => 300, 'y' => 0, 'width' => 999, 'height' => 999]], copy: true);
        $this->assertSame([100, 200], [$r['width'], $r['height']]);
    }

    public function test_redimensionnement(): void
    {
        $r = $this->editor->edit('stock/articles/1/images/photo.png', ['resize' => ['width' => 100]], copy: true);
        $this->assertSame([100, 50], [$r['width'], $r['height']]);   // proportions conservées

        $r = $this->editor->edit('stock/articles/1/images/photo.png', ['resize' => ['width' => 64, 'height' => 64]], copy: true);
        $this->assertSame([64, 64], [$r['width'], $r['height']]);
    }

    public function test_copie_ne_touche_pas_l_original_et_replace_l_ecrase(): void
    {
        $copy = $this->editor->edit('stock/articles/1/images/photo.png', ['resize' => ['width' => 40]], copy: true);
        $this->assertNotSame('stock/articles/1/images/photo.png', $copy['path']);
        $this->assertSame(400, $this->editor->info('stock/articles/1/images/photo.png')['width']);

        $replaced = $this->editor->edit('stock/articles/1/images/photo.png', ['resize' => ['width' => 40]]);
        $this->assertSame('stock/articles/1/images/photo.png', $replaced['path']);
        $this->assertSame(40, $this->editor->info('stock/articles/1/images/photo.png')['width']);
    }

    public function test_refuse_une_rotation_libre(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->editor->edit('stock/articles/1/images/photo.png', ['rotate' => 45]);
    }
}
