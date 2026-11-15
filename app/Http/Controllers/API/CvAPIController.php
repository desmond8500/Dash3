<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\ImageController;
use App\Models\CV;
use App\Models\CvItem;
use App\Models\CvSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/** CV de l'utilisateur connecté */
class CvAPIController extends Controller
{
    /** @OA\Get(path="/api/v1/cvs", tags={"CV"}, summary="Mes CV", security={{"sanctum":{}}}, @OA\Response(response=200, description="Success")) */
    public function index(Request $request)
    {
        $cvs = CV::where('user_id', $request->user()->id)
            ->withCount('sections')
            ->latest()
            ->get();

        return ResponseController::response(true, 'CV récupérés', $cvs);
    }

    /** @OA\Post(path="/api/v1/cvs", tags={"CV"}, summary="Créer un CV", security={{"sanctum":{}}}, @OA\Response(response=201, description="Créé")) */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'title' => ['nullable', 'string', 'max:255'],
            'fullname' => ['nullable', 'string', 'max:255'],
        ]);
        $user = $request->user();
        $cv = CV::create([
            'user_id' => $user->id,
            'name' => $data['name'],
            'title' => $data['title'] ?? null,
            'fullname' => $data['fullname'] ?? $user->name,
            'email' => $user->email,
        ]);

        // Structure de départ : les sections habituelles d'un CV
        $defaults = [
            ['name' => 'Expériences professionnelles', 'type' => 'experience'],
            ['name' => 'Formations', 'type' => 'formation'],
            ['name' => 'Compétences', 'type' => 'competence'],
            ['name' => 'Langues', 'type' => 'langue'],
        ];
        foreach ($defaults as $i => $section) {
            CvSection::create($section + ['c_v_id' => $cv->id, 'order' => $i]);
        }

        return response()->json(['success' => true, 'message' => 'CV créé', 'data' => $cv->load('sections.items'), 'meta' => null], 201);
    }

    /** @OA\Put(path="/api/v1/cvs/{id}", tags={"CV"}, summary="Renommer un CV", security={{"sanctum":{}}}, @OA\Response(response=200, description="Modifié")) */
    public function update(Request $request, int $id)
    {
        $cv = $this->find($request, $id);
        if (! $cv) return ResponseController::response(false, 'CV non trouvé', null, 404);
        $cv->update($request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'title' => ['sometimes', 'nullable', 'string', 'max:255'],
            'fullname' => ['sometimes', 'nullable', 'string', 'max:255'],
            'summary' => ['sometimes', 'nullable', 'string'],
            'phone' => ['sometimes', 'nullable', 'string', 'max:50'],
            'email' => ['sometimes', 'nullable', 'email', 'max:255'],
            'address' => ['sometimes', 'nullable', 'string', 'max:255'],
            'website' => ['sometimes', 'nullable', 'string', 'max:255'],
            // Personnalisation
            'accent_color' => ['sometimes', 'nullable', 'string', 'max:20', 'regex:/^#?[0-9a-fA-F]{3,8}$/'],
            'font' => ['sometimes', 'in:sans,serif,mono'],
            'layout' => ['sometimes', 'in:une_colonne,deux_colonnes'],
            'show_photo' => ['sometimes', 'boolean'],
        ]));

        return ResponseController::response(true, 'CV modifié', $cv);
    }

    /** @OA\Get(path="/api/v1/cvs/{id}", tags={"CV"}, summary="Un CV avec ses sections et ses lignes", security={{"sanctum":{}}}, @OA\Response(response=200, description="Success")) */
    public function show(Request $request, int $id)
    {
        $cv = $this->find($request, $id, ['sections.items']);
        if (! $cv) return ResponseController::response(false, 'CV non trouvé', null, 404);

        return ResponseController::response(true, 'CV récupéré', $cv);
    }

    /** @OA\Post(path="/api/v1/cvs/{id}/photo", tags={"CV"}, summary="Changer la photo du CV", security={{"sanctum":{}}}, @OA\Response(response=200, description="Modifiée")) */
    public function updatePhoto(Request $request, int $id)
    {
        $cv = $this->find($request, $id);
        if (! $cv) return ResponseController::response(false, 'CV non trouvé', null, 404);
        $request->validate(['image' => ['required', 'image', 'max:4096']]);
        $cv->update(['photo' => ImageController::update_logo("cvs/{$cv->id}", $request->file('image'))]);

        return ResponseController::response(true, 'Photo modifiée', $cv);
    }

    // ------------------------------------------------------------------
    // Sections
    // ------------------------------------------------------------------

    /** @OA\Post(path="/api/v1/cv_sections", tags={"CV"}, summary="Ajouter une section", security={{"sanctum":{}}}, @OA\Response(response=201, description="Créée")) */
    public function storeSection(Request $request)
    {
        $data = $request->validate([
            'c_v_id' => ['required', 'integer'],
            'name' => ['required', 'string', 'max:255'],
            'type' => ['nullable', 'in:experience,formation,competence,langue,libre'],
            'order' => ['nullable', 'integer'],
        ]);
        if (! $this->find($request, $data['c_v_id'])) return ResponseController::response(false, 'CV non trouvé', null, 404);
        $data['order'] ??= CvSection::where('c_v_id', $data['c_v_id'])->count();
        $section = CvSection::create($data);

        return response()->json(['success' => true, 'message' => 'Section ajoutée', 'data' => $section->load('items'), 'meta' => null], 201);
    }

    /** @OA\Put(path="/api/v1/cv_sections/{id}", tags={"CV"}, summary="Modifier une section", security={{"sanctum":{}}}, @OA\Response(response=200, description="Modifiée")) */
    public function updateSection(Request $request, int $id)
    {
        $section = $this->findSection($request, $id);
        if (! $section) return ResponseController::response(false, 'Section non trouvée', null, 404);
        $section->update($request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'type' => ['sometimes', 'in:experience,formation,competence,langue,libre'],
            'order' => ['sometimes', 'integer'],
        ]));

        return ResponseController::response(true, 'Section modifiée', $section->load('items'));
    }

    /** @OA\Delete(path="/api/v1/cv_sections/{id}", tags={"CV"}, summary="Supprimer une section et ses lignes", security={{"sanctum":{}}}, @OA\Response(response=200, description="Supprimée")) */
    public function destroySection(Request $request, int $id)
    {
        $section = $this->findSection($request, $id);
        if (! $section) return ResponseController::response(false, 'Section non trouvée', null, 404);
        CvItem::where('cv_section_id', $section->id)->delete();
        $section->delete();

        return ResponseController::response(true, 'Section supprimée', null);
    }

    // ------------------------------------------------------------------
    // Lignes
    // ------------------------------------------------------------------

    private function itemRules(bool $create): array
    {
        $s = $create ? [] : ['sometimes'];

        return [
            'title' => [...$s, 'required', 'string', 'max:255'],
            'subtitle' => [...$s, 'nullable', 'string', 'max:255'],
            'place' => [...$s, 'nullable', 'string', 'max:255'],
            'start_date' => [...$s, 'nullable', 'string', 'max:20'],
            'end_date' => [...$s, 'nullable', 'string', 'max:20'],
            'current' => [...$s, 'boolean'],
            'description' => [...$s, 'nullable', 'string'],
            'level' => [...$s, 'nullable', 'integer', 'between:1,5'],
            'order' => [...$s, 'integer'],
        ];
    }

    /** @OA\Post(path="/api/v1/cv_items", tags={"CV"}, summary="Ajouter une ligne à une section", security={{"sanctum":{}}}, @OA\Response(response=201, description="Créée")) */
    public function storeItem(Request $request)
    {
        $data = $request->validate($this->itemRules(true) + ['cv_section_id' => ['required', 'integer']]);
        if (! $this->findSection($request, $data['cv_section_id'])) return ResponseController::response(false, 'Section non trouvée', null, 404);
        $data['order'] ??= CvItem::where('cv_section_id', $data['cv_section_id'])->count();
        $item = CvItem::create($data);

        return response()->json(['success' => true, 'message' => 'Ligne ajoutée', 'data' => $item, 'meta' => null], 201);
    }

    /** @OA\Put(path="/api/v1/cv_items/{id}", tags={"CV"}, summary="Modifier une ligne", security={{"sanctum":{}}}, @OA\Response(response=200, description="Modifiée")) */
    public function updateItem(Request $request, int $id)
    {
        $item = CvItem::find($id);
        if (! $item || ! $this->findSection($request, $item->cv_section_id)) {
            return ResponseController::response(false, 'Ligne non trouvée', null, 404);
        }
        $item->update($request->validate($this->itemRules(false)));

        return ResponseController::response(true, 'Ligne modifiée', $item);
    }

    /** @OA\Delete(path="/api/v1/cv_items/{id}", tags={"CV"}, summary="Supprimer une ligne", security={{"sanctum":{}}}, @OA\Response(response=200, description="Supprimée")) */
    public function destroyItem(Request $request, int $id)
    {
        $item = CvItem::find($id);
        if (! $item || ! $this->findSection($request, $item->cv_section_id)) {
            return ResponseController::response(false, 'Ligne non trouvée', null, 404);
        }
        $item->delete();

        return ResponseController::response(true, 'Ligne supprimée', null);
    }

    // ------------------------------------------------------------------

    /** Un CV de l'utilisateur connecté */
    private function find(Request $request, int $id, array $with = []): ?CV
    {
        return CV::with($with)->where('user_id', $request->user()->id)->find($id);
    }

    /** Une section, si son CV appartient à l'utilisateur connecté */
    private function findSection(Request $request, int $id): ?CvSection
    {
        $section = CvSection::find($id);

        return $section && $this->find($request, $section->c_v_id) ? $section : null;
    }

    /** @OA\Delete(path="/api/v1/cvs/{id}", tags={"CV"}, summary="Supprimer un CV, security={{"sanctum":{}}}, @OA\Response(response=200, description="Supprimé")) */
    public function destroy(Request $request, int $id)
    {
        $cv = $this->find($request, $id, ['sections']);
        if (! $cv) return ResponseController::response(false, 'CV non trouvé', null, 404);
        Storage::disk('public')->deleteDirectory("cvs/{$cv->id}");
        CvItem::whereIn('cv_section_id', $cv->sections->pluck('id'))->delete();
        CvSection::where('c_v_id', $cv->id)->delete();
        $cv->delete();

        return ResponseController::response(true, 'CV supprimé', null);
    }
}
