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
        $perPage = min($request->get('per_page', 10), 100);

        if ($request->search) {
            $tasks = Task::where('name', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%')
                ->paginate($perPage);
        } else {
            $tasks = Task::paginate($perPage);
        }
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

        $task->priority_id = $request->priority_id;
        $task->statut_id = $request->statut_id;
        $task->expiration_date = $request->expiration_date;
        $task->start_date = $request->start_date;
        $task->end_date = $request->end_date;
        $task->favoris = $request->favoris;

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
        $task = Task::find($id);
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
        if ($task) {
            $task->client_id = $request->client_id;
            $task->projet_id = $request->projet_id;
            $task->devis_id = $request->devis_id;
            $task->building_id = $request->building_id;
            $task->stage_id = $request->stage_id;
            $task->room_id = $request->room_id;
            $task->journal_id = $request->journal_id;

            $task->name = $request->name;
            $task->description = $request->description;

            $task->priority_id = $request->priority_id;
            $task->statut_id = $request->statut_id;
            $task->expiration_date = $request->expiration_date;
            $task->start_date = $request->start_date;
            $task->end_date = $request->end_date;
            $task->favoris = $request->favoris;

            if ($task->save()) {
                return ResponseController::response(true, 'Tache mise à jour avec succès', $task, 200);
            } else {
                return ResponseController::response(false, 'Erreur lors de la mise à jour de la tache', null, 400);
            }
        } else {
            return ResponseController::response(false, 'Tache non trouvé', null, 404);
        }
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
}
