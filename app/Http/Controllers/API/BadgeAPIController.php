<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseController;
use App\Models\Badge;
use App\Models\BadgeModele;
use App\Models\Projet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Gestionnaire de badges d'un projet (Dash3Web) : badges des personnes
 * et modèles de badge, génériques ou propres à un client.
 */
class BadgeAPIController extends Controller
{
    private function notFound(string $what)
    {
        return response()->json(['success' => false, 'message' => "$what non trouvé", 'error' => null, 'meta' => null], 404);
    }

    /** Enregistre une image dans $dir (vidé avant) sous un nom sûr et unique ; renvoie « storage/… » */
    private function storeImage(string $dir, $file): string
    {
        $ext = strtolower($file->getClientOriginalExtension() ?: $file->extension() ?: 'jpg');
        $name = (Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) ?: 'image').'-'.now()->format('YmdHis').'.'.$ext;
        Storage::disk('public')->deleteDirectory($dir);
        $file->storeAs($dir, $name, 'public');

        return "storage/$dir/$name";
    }

    private function presentModele(BadgeModele $m): array
    {
        return [
            'id' => $m->id,
            'name' => $m->name,
            'client_id' => $m->client_id,
            'client_name' => $m->client?->name,
            'css' => $m->css,
            'orientation' => $m->orientation ?: 'portrait',
            'color' => $m->color,
            'file' => $m->file ? url($m->file) : null,
            'badges_count' => $m->badges_count ?? $m->badges()->count(),
        ];
    }

    private function presentBadge(Badge $b): array
    {
        return [
            'id' => $b->id,
            'projet_id' => $b->projet_id,
            'badge_modele_id' => $b->badge_modele_id,
            'prenom' => $b->prenom,
            'nom' => $b->nom,
            'fonction' => $b->fonction,
            'service' => $b->service,
            'direction' => $b->direction,
            'matricule' => $b->matricule,
            'adresse' => $b->adresse,
            'photo' => $b->photo ? url($b->photo) : null,
        ];
    }

    // ------------------------------------------------------------------
    // Modèles
    // ------------------------------------------------------------------

    /**
     * @OA\Get(path="/api/v1/badge_modeles", tags={"Badges"}, summary="Modèles de badge (?client_id= : modèles génériques + ceux du client)", security={{"sanctum":{}}}, @OA\Response(response=200, description="Success"))
     */
    public function modeles(Request $request)
    {
        $query = BadgeModele::with('client')->withCount('badges')->orderBy('name');
        if ($request->filled('client_id')) {
            $query->where(fn ($q) => $q->whereNull('client_id')->orWhere('client_id', $request->integer('client_id')));
        }

        return ResponseController::response(true, 'Modèles de badge récupérés', $query->get()->map(fn ($m) => $this->presentModele($m)));
    }

    private function modeleRules(bool $create): array
    {
        $s = $create ? [] : ['sometimes'];

        return [
            'name' => [...$s, 'required', 'string', 'max:255'],
            'client_id' => [...$s, 'nullable', 'integer', 'exists:clients,id'],
            'css' => [...$s, 'nullable', 'string'],
            'orientation' => [...$s, 'in:portrait,paysage'],
            'color' => [...$s, 'nullable', 'string', 'max:20', 'regex:/^#?[0-9a-fA-F]{3,8}$/'],
            'image' => ['nullable', 'image', 'max:4096'],
        ];
    }

    /** @OA\Post(path="/api/v1/badge_modeles", tags={"Badges"}, summary="Créer un modèle (multipart, image de fond facultative)", security={{"sanctum":{}}}, @OA\Response(response=201, description="Créé")) */
    public function storeModele(Request $request)
    {
        $data = $request->validate($this->modeleRules(true));
        unset($data['image']);
        $modele = BadgeModele::create($data);
        if ($request->hasFile('image')) {
            $modele->update(['file' => $this->storeImage("erp/badges/modeles/{$modele->id}", $request->file('image'))]);
        }

        return response()->json(['success' => true, 'message' => 'Modèle créé', 'data' => $this->presentModele($modele->fresh('client')), 'meta' => null], 201);
    }

    /** @OA\Put(path="/api/v1/badge_modeles/{id}", tags={"Badges"}, summary="Modifier un modèle", security={{"sanctum":{}}}, @OA\Response(response=200, description="Modifié")) */
    public function updateModele(Request $request, int $id)
    {
        $modele = BadgeModele::find($id);
        if (! $modele) return $this->notFound('Modèle');
        $data = $request->validate($this->modeleRules(false));
        unset($data['image']);
        $modele->update($data);

        return ResponseController::response(true, 'Modèle modifié', $this->presentModele($modele->fresh('client')));
    }

    /** @OA\Post(path="/api/v1/badge_modeles/{id}/image", tags={"Badges"}, summary="Image de fond du modèle (multipart, champ image)", security={{"sanctum":{}}}, @OA\Response(response=200, description="Modifiée")) */
    public function modeleImage(Request $request, int $id)
    {
        $modele = BadgeModele::find($id);
        if (! $modele) return $this->notFound('Modèle');
        $request->validate(['image' => ['required', 'image', 'max:4096']]);
        $modele->update(['file' => $this->storeImage("erp/badges/modeles/{$modele->id}", $request->file('image'))]);

        return ResponseController::response(true, 'Image du modèle modifiée', $this->presentModele($modele->fresh('client')));
    }

    /** @OA\Delete(path="/api/v1/badge_modeles/{id}", tags={"Badges"}, summary="Supprimer un modèle (les badges sont conservés, sans modèle)", security={{"sanctum":{}}}, @OA\Response(response=200, description="Supprimé")) */
    public function destroyModele(int $id)
    {
        $modele = BadgeModele::find($id);
        if (! $modele) return $this->notFound('Modèle');
        Badge::where('badge_modele_id', $modele->id)->update(['badge_modele_id' => null]);
        Storage::disk('public')->deleteDirectory("erp/badges/modeles/{$modele->id}");
        $modele->delete();

        return ResponseController::response(true, 'Modèle supprimé', null);
    }

    // ------------------------------------------------------------------
    // Badges
    // ------------------------------------------------------------------

    /** @OA\Get(path="/api/v1/projets/{id}/badges", tags={"Badges"}, summary="Badges d'un projet", security={{"sanctum":{}}}, @OA\Response(response=200, description="Success")) */
    public function index(int $projetId)
    {
        if (! Projet::whereKey($projetId)->exists()) return $this->notFound('Projet');
        $badges = Badge::where('projet_id', $projetId)->orderBy('nom')->orderBy('prenom')->get();

        return ResponseController::response(true, 'Badges récupérés', $badges->map(fn ($b) => $this->presentBadge($b)));
    }

    private function badgeRules(bool $create): array
    {
        $s = $create ? [] : ['sometimes'];
        $text = [...$s, 'nullable', 'string', 'max:255'];

        return [
            'badge_modele_id' => [...$s, 'nullable', 'integer', 'exists:badge_modeles,id'],
            'prenom' => $text,
            'nom' => $text,
            'fonction' => $text,
            'service' => $text,
            'direction' => $text,
            'matricule' => $text,
            'adresse' => $text,
            'image' => ['nullable', 'image', 'max:4096'],
        ];
    }

    /** @OA\Post(path="/api/v1/badges", tags={"Badges"}, summary="Créer un badge (multipart, photo facultative dans « image »)", security={{"sanctum":{}}}, @OA\Response(response=201, description="Créé")) */
    public function store(Request $request)
    {
        $data = $request->validate($this->badgeRules(true) + ['projet_id' => ['required', 'integer', 'exists:projets,id']]);
        if (! trim(($data['prenom'] ?? '').($data['nom'] ?? ''))) {
            return response()->json(['success' => false, 'message' => 'Le prénom ou le nom est obligatoire', 'error' => null, 'meta' => null], 422);
        }
        unset($data['image']);
        $badge = Badge::create($data);
        if ($request->hasFile('image')) {
            $badge->update(['photo' => $this->storeImage("erp/badges/{$badge->id}", $request->file('image'))]);
        }

        return response()->json(['success' => true, 'message' => 'Badge créé', 'data' => $this->presentBadge($badge), 'meta' => null], 201);
    }

    /** @OA\Put(path="/api/v1/badges/{id}", tags={"Badges"}, summary="Modifier un badge", security={{"sanctum":{}}}, @OA\Response(response=200, description="Modifié")) */
    public function update(Request $request, int $id)
    {
        $badge = Badge::find($id);
        if (! $badge) return $this->notFound('Badge');
        $data = $request->validate($this->badgeRules(false));
        unset($data['image']);
        $badge->update($data);

        return ResponseController::response(true, 'Badge modifié', $this->presentBadge($badge));
    }

    /** @OA\Post(path="/api/v1/badges/{id}/photo", tags={"Badges"}, summary="Photo du badge (multipart, champ image)", security={{"sanctum":{}}}, @OA\Response(response=200, description="Modifiée")) */
    public function photo(Request $request, int $id)
    {
        $badge = Badge::find($id);
        if (! $badge) return $this->notFound('Badge');
        $request->validate(['image' => ['required', 'image', 'max:4096']]);
        $badge->update(['photo' => $this->storeImage("erp/badges/{$badge->id}", $request->file('image'))]);

        return ResponseController::response(true, 'Photo modifiée', $this->presentBadge($badge));
    }

    /** @OA\Delete(path="/api/v1/badges/{id}", tags={"Badges"}, summary="Supprimer un badge", security={{"sanctum":{}}}, @OA\Response(response=200, description="Supprimé")) */
    public function destroy(int $id)
    {
        $badge = Badge::find($id);
        if (! $badge) return $this->notFound('Badge');
        Storage::disk('public')->deleteDirectory("erp/badges/{$badge->id}");
        $badge->delete();

        return ResponseController::response(true, 'Badge supprimé', null);
    }
}
