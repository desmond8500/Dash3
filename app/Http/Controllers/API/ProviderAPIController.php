<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ResponseController;
use App\Models\Provider;
use App\Models\ProviderDocument;
use App\Models\ProviderLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
            'latitude' => ['sometimes', 'nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['sometimes', 'nullable', 'numeric', 'between:-180,180'],
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
        $provider = Provider::withCount('article as articles_count')->with(['links'])->find($id);
        if (! $provider) return $this->notFound();
        $provider->logo_url = $provider->logo ? url($provider->logo) : null;
        $documents = ProviderDocument::where('provider_id', $provider->id)->latest()->get()->map(fn ($d) => $this->presentDocument($d));

        return ResponseController::response(true, 'Le fournisseur a été récupéré', $provider->toArray() + ['documents' => $documents]);
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

    // ------------------------------------------------------------------
    // Documents (catalogues, flyers, fiches…) et liens
    // ------------------------------------------------------------------

    private function presentDocument(ProviderDocument $d): array
    {
        $relative = Str::after($d->path, 'storage/');
        $disk = Storage::disk('public');

        return [
            'id' => $d->id,
            'provider_id' => $d->provider_id,
            'name' => $d->name,
            'category' => $d->category,
            'extension' => strtolower(pathinfo($d->path, PATHINFO_EXTENSION)),
            'size' => $disk->exists($relative) ? $disk->size($relative) : null,
            'url' => url($d->path),
            'created_at' => $d->created_at,
        ];
    }

    /** @OA\Get(path="/api/v1/providers/{id}/documents", tags={"Fournisseurs"}, summary="Documents du fournisseur", security={{"sanctum":{}}}, @OA\Response(response=200, description="Success")) */
    public function documents(int $id)
    {
        if (! Provider::whereKey($id)->exists()) return $this->notFound();
        $docs = ProviderDocument::where('provider_id', $id)->latest()->get()->map(fn ($d) => $this->presentDocument($d));

        return ResponseController::response(true, 'Documents récupérés', $docs);
    }

    /** @OA\Post(path="/api/v1/providers/{id}/documents", tags={"Fournisseurs"}, summary="Ajouter un document (multipart : file, name, category)", security={{"sanctum":{}}}, @OA\Response(response=201, description="Ajouté")) */
    public function storeDocument(Request $request, int $id)
    {
        if (! Provider::whereKey($id)->exists()) return $this->notFound();
        $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:50'],
            'file' => ['required', 'file', 'max:51200'],
        ]);
        $file = $request->file('file');
        $ext = strtolower($file->getClientOriginalExtension());
        if (in_array($ext, ['php', 'phtml', 'phar', 'sh', 'exe', 'bat', 'cmd', 'js', 'html', 'htm', 'svg'], true)) {
            return response()->json(['success' => false, 'message' => "Type de fichier refusé (.$ext)", 'error' => null, 'meta' => null], 422);
        }
        $dir = "stock/providers/$id/documents";
        $name = (Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) ?: 'document').'-'.Str::random(6).($ext ? ".$ext" : '');
        Storage::disk('public')->putFileAs($dir, $file, $name);

        $doc = ProviderDocument::create([
            'provider_id' => $id,
            'name' => $request->input('name') ?: $file->getClientOriginalName(),
            'category' => $request->input('category') ?: null,
            'path' => "storage/$dir/$name",
        ]);

        return response()->json(['success' => true, 'message' => 'Document ajouté', 'data' => $this->presentDocument($doc), 'meta' => null], 201);
    }

    /** @OA\Put(path="/api/v1/provider_documents/{id}", tags={"Fournisseurs"}, summary="Renommer / classer un document", security={{"sanctum":{}}}, @OA\Response(response=200, description="Modifié")) */
    public function updateDocument(Request $request, int $docId)
    {
        $doc = ProviderDocument::find($docId);
        if (! $doc) return response()->json(['success' => false, 'message' => 'Document introuvable', 'error' => null, 'meta' => null], 404);
        $doc->update($request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'category' => ['sometimes', 'nullable', 'string', 'max:50'],
        ]));

        return ResponseController::response(true, 'Document modifié', $this->presentDocument($doc));
    }

    /** @OA\Get(path="/api/v1/provider_documents/{id}/file", tags={"Fournisseurs"}, summary="Télécharger un document", security={{"sanctum":{}}}, @OA\Response(response=200, description="Fichier")) */
    public function documentFile(int $docId)
    {
        $doc = ProviderDocument::find($docId);
        $relative = $doc ? Str::after($doc->path, 'storage/') : null;
        if (! $doc || ! Storage::disk('public')->exists($relative)) {
            return response()->json(['success' => false, 'message' => 'Fichier introuvable', 'error' => null, 'meta' => null], 404);
        }
        $ext = pathinfo($relative, PATHINFO_EXTENSION);

        return Storage::disk('public')->download($relative, Str::slug(pathinfo($doc->name, PATHINFO_FILENAME)).($ext ? ".$ext" : ''));
    }

    /** @OA\Delete(path="/api/v1/provider_documents/{id}", tags={"Fournisseurs"}, summary="Supprimer un document", security={{"sanctum":{}}}, @OA\Response(response=200, description="Supprimé")) */
    public function destroyDocument(int $docId)
    {
        $doc = ProviderDocument::find($docId);
        if (! $doc) return response()->json(['success' => false, 'message' => 'Document introuvable', 'error' => null, 'meta' => null], 404);
        Storage::disk('public')->delete(Str::after($doc->path, 'storage/'));
        $doc->delete();

        return ResponseController::response(true, 'Document supprimé', null);
    }

    private function linkRules(bool $create): array
    {
        $s = $create ? [] : ['sometimes'];

        return [
            'name' => [...$s, 'required', 'string', 'max:255'],
            'url' => [...$s, 'required', 'url', 'max:2048'],
            'description' => [...$s, 'nullable', 'string'],
        ];
    }

    /** @OA\Post(path="/api/v1/providers/{id}/links", tags={"Fournisseurs"}, summary="Ajouter un lien", security={{"sanctum":{}}}, @OA\Response(response=201, description="Ajouté")) */
    public function storeLink(Request $request, int $id)
    {
        if (! Provider::whereKey($id)->exists()) return $this->notFound();
        $link = ProviderLink::create($request->validate($this->linkRules(true)) + ['provider_id' => $id]);

        return response()->json(['success' => true, 'message' => 'Lien ajouté', 'data' => $link, 'meta' => null], 201);
    }

    /** @OA\Put(path="/api/v1/provider_links/{id}", tags={"Fournisseurs"}, summary="Modifier un lien", security={{"sanctum":{}}}, @OA\Response(response=200, description="Modifié")) */
    public function updateLink(Request $request, int $linkId)
    {
        $link = ProviderLink::find($linkId);
        if (! $link) return response()->json(['success' => false, 'message' => 'Lien introuvable', 'error' => null, 'meta' => null], 404);
        $link->update($request->validate($this->linkRules(false)));

        return ResponseController::response(true, 'Lien modifié', $link);
    }

    /** @OA\Delete(path="/api/v1/provider_links/{id}", tags={"Fournisseurs"}, summary="Supprimer un lien", security={{"sanctum":{}}}, @OA\Response(response=200, description="Supprimé")) */
    public function destroyLink(int $linkId)
    {
        $link = ProviderLink::find($linkId);
        if (! $link) return response()->json(['success' => false, 'message' => 'Lien introuvable', 'error' => null, 'meta' => null], 404);
        $link->delete();

        return ResponseController::response(true, 'Lien supprimé', null);
    }
}
