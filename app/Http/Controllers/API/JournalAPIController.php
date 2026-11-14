<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseController;
use App\Models\Contact;
use App\Models\Journal;
use App\Models\JournalImage;
use App\Models\JournalIntervenant;
use App\Models\JournalSection;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class JournalAPIController extends Controller
{

    /**
     *@OA\Get(
     *      path="/api/v1/journaux",
     *      tags={"Journaux",},
     *      summary="Liste des journaux",
     *      @OA\Parameter(
     *          name="search",
     *          in="query",
     *          required=false,
     *          description="Termes de recherche",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="client_id",
     *          in="query",
     *          required=false,
     *          description="ID du client",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="projet_id",
     *          in="query",
     *          required=false,
     *          description="ID du projet",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="devis_id",
     *          in="query",
     *          required=false,
     *          description="ID du devis",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Journaux récupérés avec succès",
     *       ),
     *     )
     */
    public function index(Request $request)
    {
        $perPage = min($request->integer('per_page', 9), 100);

        $journaux = Journal::query()
            ->when($request->filled('client_id'), function ($query) use ($request) {
                $query->where('client_id', $request->client_id);
            })
            ->when($request->filled('projet_id'), function ($query) use ($request) {
                $query->where('projet_id', $request->projet_id);
            })
            ->when($request->filled('devis_id'), function ($query) use ($request) {
                $query->where('devis_id', $request->devis_id);
            })
            ->orderBy('date')
            ->paginate($perPage);

        return ResponseController::response( true,  'Les journaux ont été récupérés avec succès', $journaux,
            [
                'current_page' => $journaux->currentPage(),
                'last_page'    => $journaux->lastPage(),
                'per_page'     => $journaux->perPage(),
                'total'        => $journaux->total(),
            ]
        );
    }

    /**
     *@OA\Get(
     *      path="/api/v1/journaux/{id}",
     *      tags={"Journaux"},
     *      summary="Détails d'un journal",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID du journal",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Journal récupéré avec succès",
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Journal non trouvé",
     *       ),
     *     )
     */

    function show(int $id)
    {
        $journal = Journal::with([
            'projet:id,name,client_id',
            'projet.client:id,name',
            'invoice:id,reference,description',
            'sections' => fn ($q) => $q->orderBy('order')->orderBy('id'),
            'sections.images',
            'intervenants.contact:id,firstname,lastname,fonction,societe,phone,email,avatar',
            'intervenants.team:id,firstname,lastname,function',
            'tasks' => fn ($q) => $q->with(['priority', 'statut'])->orderBy('id'),
        ])->find($id);
        if (! $journal) {
            return ResponseController::response(false, 'Journal non trouvé', null, 404);
        }
        // Photos au niveau du journal (anciennes, sans section)
        $journal->setRelation('images', $journal->images()->whereNull('journal_section_id')->latest()->get());

        return ResponseController::response(true, 'Le journal a été récupéré avec succès', $journal);
    }

    // ------------------------------------------------------------------
    // Sections (titre, description markdown, photos)
    // ------------------------------------------------------------------

    /** @OA\Post(path="/api/v1/journal_sections", tags={"Journaux"}, summary="Ajouter une section", security={{"sanctum":{}}}, @OA\Response(response=201, description="Créée")) */
    function storeSection(Request $request)
    {
        $data = $request->validate([
            'journal_id' => ['required', 'integer', 'exists:journals,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'order' => ['nullable', 'integer'],
        ]);
        $data['order'] ??= JournalSection::where('journal_id', $data['journal_id'])->count() + 1;
        $section = JournalSection::create($data);
        $section->setRelation('images', collect());

        return response()->json(['success' => true, 'message' => 'Section ajoutée', 'data' => $section, 'meta' => null], 201);
    }

    /** @OA\Put(path="/api/v1/journal_sections/{id}", tags={"Journaux"}, summary="Modifier une section", security={{"sanctum":{}}}, @OA\Response(response=200, description="Modifiée")) */
    function updateSection(Request $request, int $id)
    {
        $section = JournalSection::find($id);
        if (! $section) return ResponseController::response(false, 'Section non trouvée', null, 404);
        $section->update($request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['sometimes', 'nullable', 'string'],
            'order' => ['sometimes', 'integer'],
        ]));

        return ResponseController::response(true, 'Section modifiée', $section->load('images'));
    }

    /** @OA\Delete(path="/api/v1/journal_sections/{id}", tags={"Journaux"}, summary="Supprimer une section et ses photos", security={{"sanctum":{}}}, @OA\Response(response=200, description="Supprimée")) */
    function destroySection(int $id)
    {
        $section = JournalSection::find($id);
        if (! $section) return ResponseController::response(false, 'Section non trouvée', null, 404);
        foreach ($section->images as $img) {
            Storage::disk('public')->delete(Str::after($img->folder, 'storage/'));
            $img->delete();
        }
        $section->delete();

        return ResponseController::response(true, 'Section supprimée', null);
    }

    /** @OA\Post(path="/api/v1/journal_sections/{id}/images", tags={"Journaux"}, summary="Ajouter des photos à une section (multipart : images[])", security={{"sanctum":{}}}, @OA\Response(response=201, description="Ajoutées")) */
    function storeSectionImages(Request $request, int $id)
    {
        $section = JournalSection::find($id);
        if (! $section) return ResponseController::response(false, 'Section non trouvée', null, 404);
        $request->validate(['images' => ['required', 'array'], 'images.*' => ['image', 'max:8192']]);

        $dir = "erp/journaux/{$section->journal_id}/sections/{$section->id}";
        foreach ($request->file('images') as $file) {
            $name = Str::random(12) . '.' . strtolower($file->getClientOriginalExtension());
            Storage::disk('public')->putFileAs($dir, $file, $name);
            JournalImage::create([
                'journal_id' => $section->journal_id,
                'journal_section_id' => $section->id,
                'folder' => "storage/$dir/$name",
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Photos ajoutées', 'data' => $section->images()->get(), 'meta' => null], 201);
    }

    /** @OA\Delete(path="/api/v1/journal_images/{id}", tags={"Journaux"}, summary="Supprimer une photo", security={{"sanctum":{}}}, @OA\Response(response=200, description="Supprimée")) */
    function destroyImage(int $id)
    {
        $img = JournalImage::find($id);
        if (! $img) return ResponseController::response(false, 'Photo non trouvée', null, 404);
        Storage::disk('public')->delete(Str::after($img->folder, 'storage/'));
        $img->delete();

        return ResponseController::response(true, 'Photo supprimée', null);
    }

    // ------------------------------------------------------------------
    // Intervenants (contacts du projet / client ou membres de l'équipe)
    // ------------------------------------------------------------------

    /** @OA\Get(path="/api/v1/journaux/{id}/options", tags={"Journaux"}, summary="Contacts et équipe disponibles comme intervenants", security={{"sanctum":{}}}, @OA\Response(response=200, description="Success")) */
    function intervenantOptions(int $id)
    {
        $journal = Journal::with('projet:id,client_id')->find($id);
        if (! $journal) return ResponseController::response(false, 'Journal non trouvé', null, 404);

        $contacts = Contact::query()
            ->when($journal->projet, fn ($q) => $q->where('projet_id', $journal->projet->id)
                ->orWhere('client_id', $journal->projet->client_id))
            ->orderBy('firstname')
            ->get(['id', 'firstname', 'lastname', 'fonction', 'societe']);

        return ResponseController::response(true, 'Options récupérées', [
            'contacts' => $contacts,
            'team' => Team::orderBy('firstname')->get(['id', 'firstname', 'lastname', 'function']),
        ]);
    }

    /** @OA\Post(path="/api/v1/journaux/{id}/intervenants", tags={"Journaux"}, summary="Ajouter un intervenant (contact_id ou team_id)", security={{"sanctum":{}}}, @OA\Response(response=201, description="Ajouté")) */
    function storeIntervenant(Request $request, int $id)
    {
        $journal = Journal::find($id);
        if (! $journal) return ResponseController::response(false, 'Journal non trouvé', null, 404);
        $data = $request->validate([
            'contact_id' => ['nullable', 'integer', 'exists:contacts,id'],
            'team_id' => ['nullable', 'integer', 'exists:teams,id'],
        ]);
        if (empty($data['contact_id']) === empty($data['team_id'])) {
            return response()->json(['success' => false, 'message' => 'Indiquez un contact ou un membre de l\'équipe', 'error' => null, 'meta' => null], 422);
        }
        $intervenant = JournalIntervenant::firstOrCreate(['journal_id' => $id] + $data);

        return response()->json(['success' => true, 'message' => 'Intervenant ajouté', 'data' => $intervenant->load(['contact', 'team']), 'meta' => null], 201);
    }

    /** @OA\Delete(path="/api/v1/journal_intervenants/{id}", tags={"Journaux"}, summary="Retirer un intervenant", security={{"sanctum":{}}}, @OA\Response(response=200, description="Retiré")) */
    function destroyIntervenant(int $id)
    {
        $intervenant = JournalIntervenant::find($id);
        if (! $intervenant) return ResponseController::response(false, 'Intervenant non trouvé', null, 404);
        $intervenant->delete();

        return ResponseController::response(true, 'Intervenant retiré', null);
    }

    /**
     *@OA\Post(
        *      path="/api/v1/journaux",
        *      tags={"Journaux",},
        *      summary="Ajouter un journal",
        *      @OA\RequestBody(
        *          required=true,
        *          @OA\JsonContent(
        *              @OA\Property(property="user_id", type="integer", example=1),
        *              @OA\Property(property="projet_id", type="integer", example=1),
        *              @OA\Property(property="devis_id", type="integer", example=1),
        *              @OA\Property(property="title", type="string", example="Journal Title"),
        *              @OA\Property(property="date", type="string", format="date", example="2023-01-01"),
        *              @OA\Property(property="description", type="string", example=""),
        *              @OA\Property(property="type", type="integer", example=1),
        *          )
        *      ),
        *      @OA\Response(
        *          response=201,
        *          description="Journal créé avec succès",
        *       ),
        *      @OA\Response(
        *          response=400,
        *          description="Erreur lors de la création du Journal",
        *       ),
        *     )
        */
    function store(Request $request)
    {
        $data = $request->validate([
            'projet_id' => ['nullable', 'integer', 'exists:projets,id'],
            'devis_id' => ['nullable', 'integer', 'exists:invoices,id'],
            'title' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date'],
            'description' => ['nullable', 'string'],
            'type' => ['nullable', 'string', 'max:255'],
        ]);
        $journal = Journal::create($data + ['user_id' => $request->user()?->id]);

        return ResponseController::response(true, 'Journal créé avec succès', $journal, 201);
    }

    function update(Request $request, int $id)
    {
        $journal = Journal::find($id);
        if (! $journal) {
            return ResponseController::response(false, 'Journal non trouvé', null, 404);
        }
        // Seuls les champs envoyés sont modifiés (avant : tout champ absent était remis à null)
        $journal->update($request->validate([
            'projet_id' => ['sometimes', 'nullable', 'integer', 'exists:projets,id'],
            'devis_id' => ['sometimes', 'nullable', 'integer', 'exists:invoices,id'],
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'date' => ['sometimes', 'required', 'date'],
            'description' => ['sometimes', 'nullable', 'string'],
            'type' => ['sometimes', 'nullable', 'string', 'max:255'],
        ]));

        return ResponseController::response(true, 'Journal mis à jour avec succès', $journal, 200);
    }

    /**
     *@OA\Delete(
        *      path="/api/v1/journaux/{id}",
        *      tags={"Journaux",},
        *      summary="Supprimer un journal",
        *      @OA\Parameter(
        *          name="id",
        *          in="path",
        *          required=true,
        *          description="ID du journal",
        *          @OA\Schema(
        *              type="integer"
        *          )
        *      ),
        *      @OA\Response(
        *          response=200,
        *          description="Journal supprimé avec succès",
        *       ),
        *      @OA\Response(
        *          response=404,
        *          description="Journal non trouvé",
        *       ),
        *      @OA\Response(
        *          response=400,
        *          description="Erreur lors de la suppression du journal",
        *       ),
        *     )
        *
        */

    function destroy(int $id)
    {
        $journal = Journal::find($id);
        if ($journal) {
            if ($journal->delete()) {
                return ResponseController::response(true, 'Journal supprimé avec succès', null, 200);
            } else {
                return ResponseController::response(false, 'Erreur lors de la suppression du journal', null, 400);
            }
        } else {
            return ResponseController::response(false, 'Journal non trouvé', null, 404);
        }
    }
}

