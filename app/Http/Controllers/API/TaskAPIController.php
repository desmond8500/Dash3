<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseController;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskAPIController extends Controller
{
    /**
     *@OA\Get(
     *      path="/api/v1/tasks",
     *      tags={"Taches"},
     *      summary="Liste des taches",
     *      @OA\Response(
     *          response=200,
     *          description="Les taches ont été récupérés avec succès",
     *       ),
     *     )
     */

    function index(Request $request)
    {
        $perPage = min((int) $request->get('per_page', 6), 100);
        $search = $request->search;

        $tasks = Task::query()
            ->with(['priority', 'statut', 'projet:id,name,client_id', 'client:id,name'])
            ->when($search, function ($q) use ($search) {
                $q->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%');
                });
            })
            // ?statut=active : tâches non terminées ; ?statut=finished : terminées (statut 4)
            ->when($request->statut === 'active', fn ($q) => $q->where('statut_id', '!=', 4))
            ->when($request->statut === 'finished', fn ($q) => $q->where('statut_id', 4))
            ->when($request->filled('projet_id'), fn ($q) => $q->where('projet_id', $request->projet_id))
            // Planning : ?from=AAAA-MM-JJ&to=AAAA-MM-JJ sur la date d'échéance
            ->when($request->filled('from'), fn ($q) => $q->whereDate('expiration_date', '>=', $request->from))
            ->when($request->filled('to'), fn ($q) => $q->whereDate('expiration_date', '<=', $request->to))
            ->orderBy('priority_id', 'desc')
            ->latest()
            ->paginate($perPage);

        return ResponseController::response(true, 'Les taches ont été récupérés avec succès', $tasks, [
            'current_page' => $tasks->currentPage(),
            'last_page' => $tasks->lastPage(),
            'per_page' => $tasks->perPage(),
            'total' => $tasks->total(),
        ]);
    }

    /**
     *@OA\Post(
     *      path="/api/v1/tasks",
     *      tags={"Taches",},
     *      summary="Ajouter une tache",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"name",},
     *              @OA\Property(property="client_id", type="integer", example="1"),
     *              @OA\Property(property="projet_id", type="integer", example="1"),
     *              @OA\Property(property="devis_id", type="integer", example="1"),
     *              @OA\Property(property="building_id", type="integer", example="1"),
     *              @OA\Property(property="stage_id", type="integer", example="1"),
     *              @OA\Property(property="room_id", type="integer", example="1"),
     *              @OA\Property(property="journal_id", type="integer", example="1"),
     *
     *              @OA\Property(property="name", type="string", example=""),
     *              @OA\Property(property="description", type="string", example=""),
     *
     *              @OA\Property(property="priority_id", type="string", example=""),
     *              @OA\Property(property="statut_id", type="string", example=""),
     *
     *              @OA\Property(property="expiration_date", type="string", example="1"),
     *              @OA\Property(property="start_date", type="string", example="1"),
     *              @OA\Property(property="end_date", type="string", example="1"),
     *              @OA\Property(property="favoris", type="boolean", example="1"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Client créé avec succès",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Erreur lors de la création du client",
     *       ),
     *     )
     */

     function store(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'expiration_date' => ['nullable', 'date'],
            'priority_id' => ['nullable', 'integer'],
            'statut_id' => ['nullable', 'integer'],
            'client_id' => ['nullable', 'integer', 'exists:clients,id'],
            'projet_id' => ['nullable', 'integer', 'exists:projets,id'],
            'devis_id' => ['nullable', 'integer', 'exists:invoices,id'],
        ]);
        $task = new Task();
        $task->client_id = $request->client_id;
        $task->projet_id = $request->projet_id;
        $task->devis_id = $request->devis_id;
        $task->building_id = $request->building_id;
        $task->stage_id = $request->stage_id;
        $task->room_id = $request->room_id;
        $task->journal_id = $request->journal_id;

        $task->name = $request->name;
        $task->description = $request->description;

        // priority_id, statut_id et favoris ne sont pas nullables : valeurs par défaut
        $task->priority_id = $request->input('priority_id', 1) ?? 1;
        $task->statut_id = $request->input('statut_id', 1) ?? 1;
        $task->expiration_date = $request->expiration_date;
        $task->start_date = $request->start_date;
        $task->end_date = $request->end_date;
        $task->favoris = (bool) $request->input('favoris', false);


        if ($task->save()) {
            return ResponseController::response(true, 'Tache créée avec succès', $task, 201);
        } else {
            return ResponseController::response(false, 'Erreur lors de la création de la tache', null, 400);
        }
     }

    /**
     * @OA\Get(
     *     path="/api/v1/tasks/{id}",
     *     tags={"Taches"},
     *     summary="Récupérer une tache",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la tache",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="La tache a été récupérée avec succès"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tache non trouvée"
     *     )
     * )
     */

    function show($id)
    {
        $task = Task::with(['priority', 'statut', 'client:id,name', 'projet:id,name,client_id', 'subtasks'])->find($id);
        if ($task) {
            return ResponseController::response(true, 'La tache a été récupéré avec succès', $task);
        } else {
            return ResponseController::response(false, 'Tache non trouvée', null, 404);
        }
    }
    /**
     *@OA\Put(
     *      path="/api/v1/tasks/{id}",
     *      tags={"Taches",},
     *      summary="Mettre à jour une Tache",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID de la tache",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"name",},
     *              @OA\Property(property="client_id", type="integer", example="1"),
     *              @OA\Property(property="projet_id", type="integer", example="1"),
     *              @OA\Property(property="devis_id", type="integer", example="1"),
     *              @OA\Property(property="building_id", type="integer", example="1"),
     *              @OA\Property(property="stage_id", type="integer", example="1"),
     *              @OA\Property(property="room_id", type="integer", example="1"),
     *              @OA\Property(property="journal_id", type="integer", example="1"),
     *
     *              @OA\Property(property="name", type="string", example=""),
     *              @OA\Property(property="description", type="string", example=""),
     *
     *              @OA\Property(property="priority_id", type="string", example=""),
     *              @OA\Property(property="statut_id", type="string", example=""),
     *
     *              @OA\Property(property="expiration_date", type="string", example="1"),
     *              @OA\Property(property="start_date", type="string", example="1"),
     *              @OA\Property(property="end_date", type="string", example="1"),
     *              @OA\Property(property="favoris", type="boolean", example="1"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Client mis à jour avec succès",
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Client non trouvé",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Erreur lors de la mise à jour du client",
     *       ),
     *     )
     */
    function update(Request $request, $id)
    {
        $task = Task::find($id);
        if (! $task) {
            return ResponseController::response(false, 'Tache non trouvé', null, 404);
        }

        // Seuls les champs envoyés sont modifiés (avant : tout champ absent était remis à null)
        $data = $request->validate([
            'client_id' => ['sometimes', 'nullable', 'integer', 'exists:clients,id'],
            'projet_id' => ['sometimes', 'nullable', 'integer', 'exists:projets,id'],
            'devis_id' => ['sometimes', 'nullable', 'integer', 'exists:invoices,id'],
            'building_id' => ['sometimes', 'nullable', 'integer'],
            'stage_id' => ['sometimes', 'nullable', 'integer'],
            'room_id' => ['sometimes', 'nullable', 'integer'],
            'journal_id' => ['sometimes', 'nullable', 'integer'],
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['sometimes', 'nullable', 'string'],
            'priority_id' => ['sometimes', 'integer'],
            'statut_id' => ['sometimes', 'integer', 'between:1,5'],
            'expiration_date' => ['sometimes', 'nullable', 'date'],
            'start_date' => ['sometimes', 'nullable', 'date'],
            'end_date' => ['sometimes', 'nullable', 'date'],
            'favoris' => ['sometimes', 'boolean'],
        ]);
        $task->update($data);

        return ResponseController::response(true, 'Tache mise à jour avec succès', $task->fresh()->load(['priority', 'statut']), 200);
    }
    /**
     *@OA\Delete(
     *      path="/api/v1/tasks/{id}",
     *      tags={"Taches",},
     *      summary="Supprimer une Tache",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID du Tache",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Tache supprimé avec succès",
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Tache non trouvé",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Erreur lors de la suppression du client",
     *       ),
     *     )
     */

    function destroy($id)
    {
        $task = Task::find($id);
        if ($task) {
            if ($task->delete()) {
                return ResponseController::response(true, 'Tache supprimée avec succès', null, 200);
            } else {
                return ResponseController::response(false, 'Erreur lors de la suppression de la Tache', null, 400);
            }
        } else {
            return ResponseController::response(false, 'Tache non trouvée', null, 404);
        }
    }

    /**
     * @OA\Post(
     *      path="/api/v1/tasks/{id}/statut",
     *      tags={"Taches"},
     *      summary="Changer le statut d'une tâche (1 Nouveau, 2 En cours, 3 En pause, 4 Terminé, 5 Clôturé)",
     *      security={{"sanctum":{}}},
     *      @OA\Response(response=200, description="Statut mis à jour")
     * )
     */
    function setStatut(Request $request, int $id)
    {
        $task = Task::find($id);
        if (! $task) {
            return response()->json(['success' => false, 'message' => 'Tache non trouvée', 'error' => null, 'meta' => null], 404);
        }
        $data = $request->validate(['statut_id' => ['required', 'integer', 'between:1,5']]);
        $task->statut_id = $data['statut_id'];
        $task->save();

        return ResponseController::response(true, 'Statut mis à jour', $task->load(['priority', 'statut']));
    }
}
