<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ResponseController;
use App\Models\Provider;
use Illuminate\Http\Request;

class ProviderAPIController extends Controller
{
    private function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'website' => ['nullable', 'url', 'max:255'],
        ];
    }

    private function notFound()
    {
        return response()->json(['success' => false, 'message' => "Le fournisseur n'a pas été trouvé", 'error' => null, 'meta' => null], 404);
    }

    /**
     * @OA\Get(
     *      path="/api/v1/providers",
     *      tags={"Fournisseurs"},
     *      summary="Liste des fournisseurs (filtre optionnel ?search=)",
     *      security={{"sanctum":{}}},
     *      @OA\Response(response=200, description="Success")
     * )
     */
    public function index(Request $request)
    {
        $providers = Provider::query()
            ->withCount('article as articles_count')
            ->when($request->filled('search'), fn ($q) => $q->where('name', 'like', '%' . $request->search . '%'))
            ->orderBy('name')
            ->get()
            ->each(fn ($provider) => $provider->logo_url = $provider->logo ? url($provider->logo) : null);

        return ResponseController::response(true, 'Les fournisseurs ont été récupérés', $providers);
    }

    /**
     * @OA\Post(
     *      path="/api/v1/providers",
     *      tags={"Fournisseurs"},
     *      summary="Créer un fournisseur",
     *      security={{"sanctum":{}}},
     *      @OA\Response(response=201, description="Fournisseur créé"),
     *      @OA\Response(response=422, description="Données invalides")
     * )
     */
    public function store(Request $request)
    {
        $data = $request->validate($this->rules());
        $data['name'] = ucfirst($data['name']);

        $provider = Provider::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Le fournisseur a été créé',
            'data' => $provider,
            'meta' => null,
        ], 201);
    }

    /**
     * @OA\Get(
     *      path="/api/v1/providers/{id}",
     *      tags={"Fournisseurs"},
     *      summary="Détail d'un fournisseur",
     *      security={{"sanctum":{}}},
     *      @OA\Response(response=200, description="Success"),
     *      @OA\Response(response=404, description="Introuvable")
     * )
     */
    public function show(int $id)
    {
        $provider = Provider::find($id);

        return $provider
            ? ResponseController::response(true, 'Le fournisseur a été récupéré', $provider)
            : $this->notFound();
    }

    /**
     * @OA\Put(
     *      path="/api/v1/providers/{id}",
     *      tags={"Fournisseurs"},
     *      summary="Modifier un fournisseur",
     *      security={{"sanctum":{}}},
     *      @OA\Response(response=200, description="Fournisseur modifié"),
     *      @OA\Response(response=404, description="Introuvable"),
     *      @OA\Response(response=422, description="Données invalides")
     * )
     */
    public function update(Request $request, int $id)
    {
        $provider = Provider::find($id);
        if (! $provider) {
            return $this->notFound();
        }

        $data = $request->validate($this->rules());
        $data['name'] = ucfirst($data['name']);
        $provider->update($data);

        return ResponseController::response(true, 'Le fournisseur a été modifié', $provider->fresh());
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/providers/{id}",
     *      tags={"Fournisseurs"},
     *      summary="Supprimer un fournisseur",
     *      security={{"sanctum":{}}},
     *      @OA\Response(response=200, description="Fournisseur supprimé"),
     *      @OA\Response(response=404, description="Introuvable")
     * )
     */
    public function destroy(int $id)
    {
        $provider = Provider::find($id);
        if (! $provider) {
            return $this->notFound();
        }

        $provider->delete();

        return ResponseController::response(true, 'Le fournisseur a été supprimé', null);
    }

    /**
     * @OA\Post(
     *      path="/api/v1/providers/{id}/logo",
     *      tags={"Fournisseurs"},
     *      summary="Remplacer le logo (multipart, champ image)",
     *      security={{"sanctum":{}}},
     *      @OA\Response(response=200, description="Logo mis à jour")
     * )
     */
    public function updateLogo(Request $request, int $id)
    {
        $provider = Provider::find($id);
        if (! $provider) {
            return $this->notFound();
        }
        $request->validate(['image' => ['required', 'image', 'max:4096']]);

        // Même dossier que la page web
        $provider->logo = ImageController::update_logo("stock/providers/$provider->id/logo", $request->file('image'));
        $provider->save();

        return ResponseController::response(true, 'Logo mis à jour', ['logo_url' => url($provider->logo)]);
    }
}
