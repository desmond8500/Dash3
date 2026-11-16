<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseController;
use App\Services\ImageEditor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use InvalidArgumentException;
use Throwable;

/**
 * Rogner / pivoter / redimensionner une image déjà enregistrée.
 * Le front envoie l'URL (ou le chemin « storage/… ») qu'il affiche déjà.
 */
class ImageEditAPIController extends Controller
{
    private function editor(): ImageEditor
    {
        return new ImageEditor(Storage::disk('public')->path(''));
    }

    /**
     * Résout le chemin et vérifie la permission du dossier.
     * Renvoie le chemin relatif, ou une réponse d'erreur.
     */
    private function authorizePath(?string $input): string|\Illuminate\Http\JsonResponse
    {
        if (! $input) {
            return $this->error('Le chemin de l\'image est requis', 422);
        }
        try {
            $path = $this->editor()->resolve($input);
        } catch (InvalidArgumentException $e) {
            return $this->error($e->getMessage(), str_contains($e->getMessage(), 'introuvable') ? 404 : 422);
        }

        foreach (config('images.editable', []) as $prefix => $ability) {
            if (str_starts_with($path, $prefix)) {
                return Gate::allows($ability)
                    ? $path
                    : $this->error("Vous n'avez pas la permission de modifier cette image.", 403);
            }
        }

        return $this->error('Cette image ne peut pas être modifiée', 403);
    }

    private function error(string $message, int $status)
    {
        return response()->json(['success' => false, 'message' => $message, 'error' => null, 'meta' => null], $status);
    }

    private function payload(array $info): array
    {
        return $info + [
            'url' => url('storage/' . $info['path']) . '?v=' . $info['version'],
            'storage_path' => 'storage/' . $info['path'],
        ];
    }

    /**
     * @OA\Get(path="/api/v1/images/info", tags={"Images"}, summary="Dimensions d'une image (?path=URL ou storage/…)",
     *      security={{"sanctum":{}}},
     *      @OA\Parameter(name="path", in="query", required=true, @OA\Schema(type="string")),
     *      @OA\Response(response=200, description="width, height, size, url"))
     */
    public function info(Request $request)
    {
        $path = $this->authorizePath($request->query('path'));
        if (! is_string($path)) return $path;

        try {
            return ResponseController::response(true, 'Informations de l\'image', $this->payload($this->editor()->info($path)));
        } catch (Throwable $e) {
            Log::warning('images.info', ['path' => $path, 'error' => $e->getMessage()]);

            return $this->error('Image illisible', 422);
        }
    }

    /**
     * @OA\Post(path="/api/v1/images/edit", tags={"Images"}, summary="Pivoter, retourner, rogner, redimensionner une image",
     *      description="Ordre : rotation → retournement → rognage (pixels de l'image pivotée) → redimensionnement. mode=replace écrase le fichier (les liens existants restent valables), mode=copy crée une copie à côté.",
     *      security={{"sanctum":{}}},
     *      @OA\RequestBody(@OA\JsonContent(
     *          required={"path"},
     *          @OA\Property(property="path", type="string", example="https://dash3.yonkou.info/storage/stock/articles/12/images/photo.jpg"),
     *          @OA\Property(property="rotate", type="integer", enum={0,90,180,270}),
     *          @OA\Property(property="flip_h", type="boolean"),
     *          @OA\Property(property="flip_v", type="boolean"),
     *          @OA\Property(property="crop", type="object", @OA\Property(property="x", type="integer"), @OA\Property(property="y", type="integer"), @OA\Property(property="width", type="integer"), @OA\Property(property="height", type="integer")),
     *          @OA\Property(property="resize", type="object", @OA\Property(property="width", type="integer"), @OA\Property(property="height", type="integer")),
     *          @OA\Property(property="quality", type="integer", minimum=10, maximum=100),
     *          @OA\Property(property="mode", type="string", enum={"replace","copy"})
     *      )),
     *      @OA\Response(response=200, description="Image enregistrée : path, url, width, height, size"))
     */
    public function edit(Request $request)
    {
        $data = $request->validate([
            'path' => ['required', 'string', 'max:1024'],
            'rotate' => ['nullable', 'integer', 'in:0,90,180,270,-90,-180,-270'],
            'flip_h' => ['nullable', 'boolean'],
            'flip_v' => ['nullable', 'boolean'],
            'crop' => ['nullable', 'array'],
            'crop.x' => ['required_with:crop', 'numeric', 'min:0'],
            'crop.y' => ['required_with:crop', 'numeric', 'min:0'],
            'crop.width' => ['required_with:crop', 'numeric', 'min:1'],
            'crop.height' => ['required_with:crop', 'numeric', 'min:1'],
            'resize' => ['nullable', 'array'],
            'resize.width' => ['nullable', 'integer', 'min:1', 'max:' . ImageEditor::MAX_SIDE],
            'resize.height' => ['nullable', 'integer', 'min:1', 'max:' . ImageEditor::MAX_SIDE],
            'quality' => ['nullable', 'integer', 'min:10', 'max:100'],
            'mode' => ['nullable', 'in:replace,copy'],
        ]);

        $path = $this->authorizePath($data['path']);
        if (! is_string($path)) return $path;

        $ops = [
            'rotate' => (int) ($data['rotate'] ?? 0),
            'flip_h' => (bool) ($data['flip_h'] ?? false),
            'flip_v' => (bool) ($data['flip_v'] ?? false),
            'crop' => $data['crop'] ?? null,
            'resize' => $data['resize'] ?? null,
            'quality' => (int) ($data['quality'] ?? config('images.quality', 90)),
        ];

        try {
            $result = $this->editor()->edit($path, $ops, ($data['mode'] ?? 'replace') === 'copy');
        } catch (InvalidArgumentException $e) {
            return $this->error($e->getMessage(), 422);
        } catch (Throwable $e) {
            Log::error('images.edit', ['path' => $path, 'ops' => $ops, 'error' => $e->getMessage()]);

            return $this->error('Impossible de modifier cette image', 422);
        }

        return ResponseController::response(true, 'Image modifiée', $this->payload($result));
    }
}
