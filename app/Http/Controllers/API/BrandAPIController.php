<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ResponseController;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandAPIController extends Controller
{
    private function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ];
    }

    private function notFound()
    {
        return response()->json(['success' => false, 'message' => "La marque n'a pas été trouvée", 'error' => null, 'meta' => null], 404);
    }

    /**
     * @OA\Get(
     *      path="/api/v1/brands",
     *      tags={"Marques"},
     *      summary="Liste des marques (filtre optionnel ?search=)",
     *      security={{"sanctum":{}}},
     *      @OA\Response(response=200, description="Success")
     * )
     */
    public function index(Request $request)
    {
        $brands = Brand::query()
            ->withCount('article as articles_count')
            ->when($request->filled('search'), fn ($q) => $q->where('name', 'like', '%' . $request->search . '%'))
            ->orderBy('name')
            ->get()
            ->each(fn ($brand) => $brand->logo_url = $brand->logo ? url($brand->logo) : null);

        return ResponseController::response(true, 'Les marques ont été récupérées', $brands);
    }

    /**
     * @OA\Post(
     *      path="/api/v1/brands",
     *      tags={"Marques"},
     *      summary="Créer une marque",
     *      security={{"sanctum":{}}},
     *      @OA\Response(response=201, description="Marque créée"),
     *      @OA\Response(response=422, description="Données invalides")
     * )
     */
    public function store(Request $request)
    {
        $data = $request->validate($this->rules());
        $data['name'] = ucfirst($data['name']);

        $brand = Brand::create($data);

        return response()->json([
            'success' => true,
            'message' => 'La marque a été créée',
            'data' => $brand,
            'meta' => null,
        ], 201);
    }

    /**
     * @OA\Get(
     *      path="/api/v1/brands/{id}",
     *      tags={"Marques"},
     *      summary="Détail d'une marque",
     *      security={{"sanctum":{}}},
     *      @OA\Response(response=200, description="Success"),
     *      @OA\Response(response=404, description="Introuvable")
     * )
     */
    public function show(int $id)
    {
        $brand = Brand::find($id);

        return $brand
            ? ResponseController::response(true, 'La marque a été récupérée', $brand)
            : $this->notFound();
    }

    /**
     * @OA\Put(
     *      path="/api/v1/brands/{id}",
     *      tags={"Marques"},
     *      summary="Modifier une marque",
     *      security={{"sanctum":{}}},
     *      @OA\Response(response=200, description="Marque modifiée"),
     *      @OA\Response(response=404, description="Introuvable"),
     *      @OA\Response(response=422, description="Données invalides")
     * )
     */
    public function update(Request $request, int $id)
    {
        $brand = Brand::find($id);
        if (! $brand) {
            return $this->notFound();
        }

        $data = $request->validate($this->rules());
        $data['name'] = ucfirst($data['name']);
        $brand->update($data);

        return ResponseController::response(true, 'La marque a été modifiée', $brand->fresh());
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/brands/{id}",
     *      tags={"Marques"},
     *      summary="Supprimer une marque",
     *      security={{"sanctum":{}}},
     *      @OA\Response(response=200, description="Marque supprimée"),
     *      @OA\Response(response=404, description="Introuvable")
     * )
     */
    public function destroy(int $id)
    {
        $brand = Brand::find($id);
        if (! $brand) {
            return $this->notFound();
        }

        $brand->delete();

        return ResponseController::response(true, 'La marque a été supprimée', null);
    }

    /**
     * @OA\Post(
     *      path="/api/v1/brands/{id}/logo",
     *      tags={"Marques"},
     *      summary="Remplacer le logo (multipart, champ image)",
     *      security={{"sanctum":{}}},
     *      @OA\Response(response=200, description="Logo mis à jour")
     * )
     */
    public function updateLogo(Request $request, int $id)
    {
        $brand = Brand::find($id);
        if (! $brand) {
            return $this->notFound();
        }
        $request->validate(['image' => ['required', 'image', 'max:4096']]);

        // Même dossier que la page web
        $brand->logo = ImageController::update_logo("stock/brands/$brand->id/logo", $request->file('image'));
        $brand->save();

        return ResponseController::response(true, 'Logo mis à jour', ['logo_url' => url($brand->logo)]);
    }
}
