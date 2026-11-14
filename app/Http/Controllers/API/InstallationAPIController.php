<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseController;
use App\Models\Building;
use App\Models\Equipement;
use App\Models\InstallationSysteme;
use App\Models\Plan;
use App\Models\PlanMarker;
use App\Models\Projet;
use App\Models\Systeme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Installations d'un projet : bâtiments › systèmes › équipements de base › équipements secondaires,
 * et plans sur lesquels on place les équipements.
 */
class InstallationAPIController extends Controller
{
    private function notFound(string $what)
    {
        return response()->json(['success' => false, 'message' => "$what introuvable", 'error' => null, 'meta' => null], 404);
    }

    // ------------------------------------------------------------------
    // Arborescence
    // ------------------------------------------------------------------

    /**
     * @OA\Get(path="/api/v1/projets/{id}/installations", tags={"Installations"},
     *      summary="Bâtiments du projet avec leurs systèmes et équipements (arborescence complète)",
     *      security={{"sanctum":{}}}, @OA\Response(response=200, description="Success"))
     */
    public function index(int $projetId)
    {
        if (! Projet::whereKey($projetId)->exists()) {
            return $this->notFound('Projet');
        }

        $systemes = InstallationSysteme::with(['baseEquipements.children', 'systeme:id,name,icon'])
            ->where('projet_id', $projetId)
            ->orderBy('order')
            ->orderBy('id')
            ->get();

        $buildings = Building::where('projet_id', $projetId)
            ->orderBy('order')
            ->orderBy('id')
            ->get(['id', 'projet_id', 'name', 'description', 'order'])
            ->map(function ($b) use ($systemes) {
                $b->systemes = $systemes->where('building_id', $b->id)->values();
                return $b;
            });

        return ResponseController::response(true, 'Installations récupérées', [
            'buildings' => $buildings,
            // Systèmes rattachés au projet sans bâtiment
            'unassigned' => $systemes->whereNull('building_id')->values(),
            // Catalogue de systèmes (vidéosurveillance, alarme…)
            'catalogue' => Systeme::orderBy('name')->get(['id', 'name', 'icon']),
        ]);
    }

    // ------------------------------------------------------------------
    // Bâtiments
    // ------------------------------------------------------------------

    /** @OA\Post(path="/api/v1/buildings", tags={"Installations"}, summary="Créer un bâtiment", security={{"sanctum":{}}}, @OA\Response(response=201, description="Créé")) */
    public function storeBuilding(Request $request)
    {
        $data = $request->validate([
            'projet_id' => ['required', 'integer', 'exists:projets,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'order' => ['nullable', 'integer'],
        ]);
        $building = Building::create($data + ['order' => 0]);

        return response()->json(['success' => true, 'message' => 'Bâtiment créé', 'data' => $building, 'meta' => null], 201);
    }

    /** @OA\Put(path="/api/v1/buildings/{id}", tags={"Installations"}, summary="Modifier un bâtiment", security={{"sanctum":{}}}, @OA\Response(response=200, description="Modifié")) */
    public function updateBuilding(Request $request, int $id)
    {
        $building = Building::find($id);
        if (! $building) return $this->notFound('Bâtiment');
        $building->update($request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['sometimes', 'nullable', 'string'],
            'order' => ['sometimes', 'integer'],
        ]));

        return ResponseController::response(true, 'Bâtiment modifié', $building);
    }

    /** @OA\Delete(path="/api/v1/buildings/{id}", tags={"Installations"}, summary="Supprimer un bâtiment", security={{"sanctum":{}}}, @OA\Response(response=200, description="Supprimé")) */
    public function destroyBuilding(int $id)
    {
        $building = Building::find($id);
        if (! $building) return $this->notFound('Bâtiment');
        $building->delete();

        return ResponseController::response(true, 'Bâtiment supprimé', null);
    }

    // ------------------------------------------------------------------
    // Systèmes
    // ------------------------------------------------------------------

    /** @OA\Post(path="/api/v1/installation_systemes", tags={"Installations"}, summary="Ajouter un système à un bâtiment", security={{"sanctum":{}}}, @OA\Response(response=201, description="Créé")) */
    public function storeSysteme(Request $request)
    {
        $data = $request->validate([
            'projet_id' => ['required', 'integer', 'exists:projets,id'],
            'building_id' => ['nullable', 'integer', 'exists:buildings,id'],
            'systeme_id' => ['nullable', 'integer', 'exists:systemes,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'order' => ['nullable', 'integer'],
        ]);
        if (! empty($data['building_id']) && ! Building::whereKey($data['building_id'])->where('projet_id', $data['projet_id'])->exists()) {
            return response()->json(['success' => false, 'message' => "Ce bâtiment n'appartient pas au projet", 'error' => null, 'meta' => null], 422);
        }
        $systeme = InstallationSysteme::create($data + ['order' => 0]);

        return response()->json(['success' => true, 'message' => 'Système ajouté', 'data' => $systeme, 'meta' => null], 201);
    }

    /** @OA\Put(path="/api/v1/installation_systemes/{id}", tags={"Installations"}, summary="Modifier un système", security={{"sanctum":{}}}, @OA\Response(response=200, description="Modifié")) */
    public function updateSysteme(Request $request, int $id)
    {
        $systeme = InstallationSysteme::find($id);
        if (! $systeme) return $this->notFound('Système');
        $systeme->update($request->validate([
            'building_id' => ['sometimes', 'nullable', 'integer', 'exists:buildings,id'],
            'systeme_id' => ['sometimes', 'nullable', 'integer', 'exists:systemes,id'],
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['sometimes', 'nullable', 'string'],
            'order' => ['sometimes', 'integer'],
        ]));

        return ResponseController::response(true, 'Système modifié', $systeme);
    }

    /** @OA\Delete(path="/api/v1/installation_systemes/{id}", tags={"Installations"}, summary="Supprimer un système et ses équipements", security={{"sanctum":{}}}, @OA\Response(response=200, description="Supprimé")) */
    public function destroySysteme(int $id)
    {
        $systeme = InstallationSysteme::find($id);
        if (! $systeme) return $this->notFound('Système');
        $systeme->delete();

        return ResponseController::response(true, 'Système supprimé', null);
    }

    // ------------------------------------------------------------------
    // Équipements
    // ------------------------------------------------------------------

    private function equipementRules(bool $create): array
    {
        $req = $create ? 'required' : 'sometimes';

        return [
            'installation_systeme_id' => [$create ? 'required' : 'prohibited', 'integer', 'exists:installation_systemes,id'],
            'parent_id' => ['sometimes', 'nullable', 'integer', 'exists:equipements,id'],
            'article_id' => ['sometimes', 'nullable', 'integer', 'exists:articles,id'],
            'name' => [$req, 'string', 'max:255'],
            'type' => ['sometimes', 'nullable', 'string', 'max:255'],
            'modele' => ['sometimes', 'nullable', 'string', 'max:255'],
            'caracteristiques' => ['sometimes', 'nullable', 'array'],
            'caracteristiques.*' => ['nullable', 'string', 'max:255'],
            'description' => ['sometimes', 'nullable', 'string'],
            'order' => ['sometimes', 'integer'],
        ];
    }

    /** Le parent doit être un équipement de base du même système */
    private function invalidParent(?int $parentId, int $systemeId, ?int $selfId = null): ?string
    {
        if (! $parentId) return null;
        $parent = Equipement::find($parentId);
        if (! $parent || $parent->installation_systeme_id !== $systemeId) return "L'équipement parent n'appartient pas à ce système";
        if ($parent->parent_id) return "Un équipement secondaire ne peut pas avoir d'équipements rattachés";
        if ($selfId && $parent->id === $selfId) return 'Un équipement ne peut pas être son propre parent';
        return null;
    }

    /** @OA\Post(path="/api/v1/equipements", tags={"Installations"}, summary="Ajouter un équipement (de base ou secondaire)", security={{"sanctum":{}}}, @OA\Response(response=201, description="Créé")) */
    public function storeEquipement(Request $request)
    {
        $data = $request->validate($this->equipementRules(true));
        if ($msg = $this->invalidParent($data['parent_id'] ?? null, (int) $data['installation_systeme_id'])) {
            return response()->json(['success' => false, 'message' => $msg, 'error' => null, 'meta' => null], 422);
        }
        $equipement = Equipement::create($data + ['order' => 0]);

        return response()->json(['success' => true, 'message' => 'Équipement ajouté', 'data' => $equipement->load('children'), 'meta' => null], 201);
    }

    /** @OA\Put(path="/api/v1/equipements/{id}", tags={"Installations"}, summary="Modifier un équipement", security={{"sanctum":{}}}, @OA\Response(response=200, description="Modifié")) */
    public function updateEquipement(Request $request, int $id)
    {
        $equipement = Equipement::find($id);
        if (! $equipement) return $this->notFound('Équipement');
        $data = $request->validate($this->equipementRules(false));
        if (array_key_exists('parent_id', $data)) {
            if ($msg = $this->invalidParent($data['parent_id'], $equipement->installation_systeme_id, $equipement->id)) {
                return response()->json(['success' => false, 'message' => $msg, 'error' => null, 'meta' => null], 422);
            }
            if ($data['parent_id'] && $equipement->children()->exists()) {
                return response()->json(['success' => false, 'message' => 'Un équipement qui a des équipements rattachés ne peut pas devenir secondaire', 'error' => null, 'meta' => null], 422);
            }
        }
        $equipement->update($data);

        return ResponseController::response(true, 'Équipement modifié', $equipement->load('children'));
    }

    /** @OA\Delete(path="/api/v1/equipements/{id}", tags={"Installations"}, summary="Supprimer un équipement (et ses équipements secondaires)", security={{"sanctum":{}}}, @OA\Response(response=200, description="Supprimé")) */
    public function destroyEquipement(int $id)
    {
        $equipement = Equipement::find($id);
        if (! $equipement) return $this->notFound('Équipement');
        $equipement->delete();

        return ResponseController::response(true, 'Équipement supprimé', null);
    }

    // ------------------------------------------------------------------
    // Plans
    // ------------------------------------------------------------------

    private const PLAN_EXTENSIONS = ['pdf' => 'pdf', 'png' => 'image', 'jpg' => 'image', 'jpeg' => 'image', 'webp' => 'image', 'dwg' => 'dwg'];

    /** @OA\Get(path="/api/v1/projets/{id}/plans", tags={"Installations"}, summary="Plans du projet", security={{"sanctum":{}}}, @OA\Response(response=200, description="Success")) */
    public function plans(int $projetId)
    {
        $plans = Plan::withCount('markers')
            ->where('projet_id', $projetId)
            ->orderBy('name')
            ->get();

        return ResponseController::response(true, 'Plans récupérés', $plans);
    }

    /** @OA\Post(path="/api/v1/plans", tags={"Installations"}, summary="Importer un plan (multipart : file, projet_id, building_id?, name?) — PDF, PNG, JPG, WEBP ou DWG", security={{"sanctum":{}}}, @OA\Response(response=201, description="Importé")) */
    public function storePlan(Request $request)
    {
        $request->validate([
            'projet_id' => ['required', 'integer', 'exists:projets,id'],
            'building_id' => ['nullable', 'integer', 'exists:buildings,id'],
            'name' => ['nullable', 'string', 'max:255'],
            'file' => ['required', 'file', 'max:30720'], // 30 Mo
        ]);
        $file = $request->file('file');
        $ext = strtolower($file->getClientOriginalExtension());
        if (! isset(self::PLAN_EXTENSIONS[$ext])) {
            return response()->json(['success' => false, 'message' => 'Format non pris en charge (PDF, PNG, JPG, WEBP ou DWG)', 'error' => null, 'meta' => null], 422);
        }

        $dir = "erp/projets/{$request->projet_id}/plans";
        $name = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '-' . Str::random(6) . ".$ext";
        Storage::disk('public')->putFileAs($dir, $file, $name);

        $plan = Plan::create([
            'projet_id' => $request->projet_id,
            'building_id' => $request->building_id,
            'name' => $request->input('name') ?: pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
            'file' => "storage/$dir/$name",
            'mime' => $file->getClientMimeType(),
            'kind' => self::PLAN_EXTENSIONS[$ext],
        ]);

        return response()->json(['success' => true, 'message' => 'Plan importé', 'data' => $plan, 'meta' => null], 201);
    }

    /** @OA\Put(path="/api/v1/plans/{id}", tags={"Installations"}, summary="Renommer un plan ou changer son bâtiment", security={{"sanctum":{}}}, @OA\Response(response=200, description="Modifié")) */
    public function updatePlan(Request $request, int $id)
    {
        $plan = Plan::find($id);
        if (! $plan) return $this->notFound('Plan');
        $plan->update($request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'building_id' => ['sometimes', 'nullable', 'integer', 'exists:buildings,id'],
        ]));

        return ResponseController::response(true, 'Plan modifié', $plan);
    }

    /** @OA\Delete(path="/api/v1/plans/{id}", tags={"Installations"}, summary="Supprimer un plan (fichier et emplacements)", security={{"sanctum":{}}}, @OA\Response(response=200, description="Supprimé")) */
    public function destroyPlan(int $id)
    {
        $plan = Plan::find($id);
        if (! $plan) return $this->notFound('Plan');
        Storage::disk('public')->delete(Str::after($plan->file, 'storage/'));
        $plan->delete();

        return ResponseController::response(true, 'Plan supprimé', null);
    }

    /** @OA\Get(path="/api/v1/plans/{id}/markers", tags={"Installations"}, summary="Emplacements des équipements sur le plan", security={{"sanctum":{}}}, @OA\Response(response=200, description="Success")) */
    public function markers(int $id)
    {
        $plan = Plan::find($id);
        if (! $plan) return $this->notFound('Plan');

        return ResponseController::response(true, 'Emplacements récupérés', [
            'plan' => $plan,
            'markers' => $plan->markers()->with('equipement:id,name,type,parent_id,installation_systeme_id')->get(),
        ]);
    }

    /**
     * @OA\Put(path="/api/v1/plans/{id}/markers", tags={"Installations"},
     *      summary="Remplacer tous les emplacements du plan (markers: [{equipement_id?, page, x, y, label?, icon?, color?}])",
     *      security={{"sanctum":{}}}, @OA\Response(response=200, description="Enregistré"))
     */
    public function saveMarkers(Request $request, int $id)
    {
        $plan = Plan::find($id);
        if (! $plan) return $this->notFound('Plan');
        $data = $request->validate([
            'markers' => ['present', 'array', 'max:2000'],
            'markers.*.equipement_id' => ['nullable', 'integer', 'exists:equipements,id'],
            'markers.*.page' => ['nullable', 'integer', 'min:1'],
            'markers.*.x' => ['required', 'numeric', 'between:0,1'],
            'markers.*.y' => ['required', 'numeric', 'between:0,1'],
            'markers.*.label' => ['nullable', 'string', 'max:255'],
            'markers.*.icon' => ['nullable', 'string', 'max:50'],
            'markers.*.color' => ['nullable', 'string', 'max:20'],
        ]);

        DB::transaction(function () use ($plan, $data) {
            $plan->markers()->delete();
            foreach ($data['markers'] as $m) {
                $plan->markers()->create([
                    'equipement_id' => $m['equipement_id'] ?? null,
                    'page' => $m['page'] ?? 1,
                    'x' => $m['x'],
                    'y' => $m['y'],
                    'label' => $m['label'] ?? null,
                    'icon' => $m['icon'] ?? null,
                    'color' => $m['color'] ?? null,
                ]);
            }
        });

        return $this->markers($id);
    }
}
