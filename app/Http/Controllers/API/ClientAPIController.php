<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseController;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientAPIController extends Controller
{
    /**
    *@OA\Get(
    *      path="/api/v1/clients",
    *      tags={"Clients",},
    *      summary="Liste des clients",
    *      @OA\Response(
    *          response=200,
    *          description="Clients récupérés avec succès",
    *       ),
    *     )
    */
    function index(){
         $clients = Client::all();
         return ResponseController::response(true, 'Les  clients  ont été récupérés avec succès', $clients);
    }

    /**
    *@OA\Get(
    *      path="/api/v1/clients/{id}",
    *      tags={"Clients",},
    *      summary="Détails d'un client",
    *      @OA\Parameter(
    *          name="id",
    *          in="path",
    *          required=true,
    *          description="ID du client",
    *          @OA\Schema(
    *              type="integer"
    *          )
    *      ),
    *      @OA\Response(
    *          response=200,
    *          description="Client récupéré avec succès",
    *       ),
    *      @OA\Response(
    *          response=404,
    *          description="Client non trouvé",
    *       ),
    *     )
    */

    function show($id){
        $client = Client::find($id);
        if ($client) {
            return ResponseController::response(true, 'Le client a été récupéré avec succès', $client);
        } else {
            return ResponseController::response(false, 'Client non trouvé', null, 404);
        }
    }

    /**
    *@OA\Post(
    *      path="/api/v1/clients",
    *      tags={"Clients",},
    *      summary="Ajouter un client",
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(
    *              required={"name",},
    *              @OA\Property(property="name", type="string", example="Client Name"),
    *              @OA\Property(property="description", type="string", example=""),
    *              @OA\Property(property="avatar", type="string", example=""),
    *              @OA\Property(property="status", type="integer", example="1"),
    *              @OA\Property(property="type", type="1", example="1"),
    *              @OA\Property(property="favorite", type="string", example="1"),
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
        $client = new Client();
        $client->name = $request->name;
        $client->description = $request->description;
        $client->address = $request->address;
        // $client->avatar = $request->avatar;
        $client->status = $request->status;
        $client->type = $request->type;
        $client->favorite = $request->favorite;

        if ($client->save()) {
            return ResponseController::response(true, 'Client créé avec succès', null, 201);
        } else {
            return ResponseController::response(false, 'Erreur lors de la création du client', null, 400);
        }
    }

    /**
    *@OA\Put(
    *      path="/api/v1/clients/{id}",
    *      tags={"Clients",},
    *      summary="Mettre à jour un client",
    *      @OA\Parameter(
    *          name="id",
    *          in="path",
    *          required=true,
    *          description="ID du client",
    *          @OA\Schema(
    *              type="integer"
    *          )
    *      ),
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(
    *              required={"name",},
    *              @OA\Property(property="name", type="string", example="Client Name"),
    *              @OA\Property(property="description", type="string", example=""),
    *              @OA\Property(property="avatar", type="string", example=""),
    *              @OA\Property(property="status", type="integer", example="1"),
    *              @OA\Property(property="type", type="1", example="1"),
    *              @OA\Property(property="favorite", type="string", example="1"),
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
    function update(Request $request, $id){
        $client = Client::find($id);
        if ($client) {
            $client->name = $request->name;
            $client->description = $request->description;
            $client->address = $request->address;
            // $client->avatar = $request->avatar;
            $client->status = $request->status;
            $client->type = $request->type;
            $client->favorite = $request->favorite;

            if ($client->save()) {
                return ResponseController::response(true, 'Client mis à jour avec succès', null, 200);
            } else {
                return ResponseController::response(false, 'Erreur lors de la mise à jour du client', null, 400);
            }
        } else {
            return ResponseController::response(false, 'Client non trouvé', null, 404);
        }
    }
    /**
    *@OA\Delete(
    *      path="/api/v1/clients/{id}",
    *      tags={"Clients",},
    *      summary="Supprimer un client",
    *      @OA\Parameter(
    *          name="id",
    *          in="path",
    *          required=true,
    *          description="ID du client",
    *          @OA\Schema(
    *              type="integer"
    *          )
    *      ),
    *      @OA\Response(
    *          response=200,
    *          description="Client supprimé avec succès",
    *       ),
    *      @OA\Response(
    *          response=404,
    *          description="Client non trouvé",
    *       ),
    *      @OA\Response(
    *          response=400,
    *          description="Erreur lors de la suppression du client",
    *       ),
    *     )
    */
    function destroy($id){
        $client = Client::find($id);
        if ($client) {
            if ($client->delete()) {
                return ResponseController::response(true, 'Client supprimé avec succès', null, 200);
            } else {
                return ResponseController::response(false, 'Erreur lors de la suppression du client', null, 400);
            }
        } else {
            return ResponseController::response(false, 'Client non trouvé', null, 404);
        }
    }
    /**
    *@OA\Get(
    *      path="/api/v1/clients/{id}/projets",
    *      tags={"Clients",},
    *      summary="Liste des projets d'un client",
    *      @OA\Parameter(
    *          name="id",
    *          in="path",
    *          required=true,
    *          description="ID du client",
    *          @OA\Schema(
    *              type="integer"
    *          )
    *      ),
    *      @OA\Response(
    *          response=200,
    *          description="Projets récupérés avec succès",
    *       ),
    *      @OA\Response(
    *          response=404,
    *          description="Client non trouvé",
    *       ),
    *      @OA\Response(
    *          response=400,
    *          description="Erreur lors de la récupération des projets",
    *       ),
    *     )
    */

    function getProjets($id){
        $client = Client::find($id);
        if ($client) {
            $projets = $client->projets;
            return ResponseController::response(true, 'Projets récupérés avec succès', $projets, 200);
        } else {
            return ResponseController::response(false, 'Client non trouvé', null, 404);
        }
    }
    /**
    *@OA\Get(
    *      path="/api/v1/clients/{id}/tasks",
    *      tags={"Clients",},
    *      summary="Liste des tâches d'un client",
    *      @OA\Parameter(
    *          name="id",
    *          in="path",
    *          required=true,
    *          description="ID du client",
    *          @OA\Schema(
    *              type="integer"
    *          )
    *      ),
    *      @OA\Response(
    *          response=200,
    *          description="Tâches récupérées avec succès",
    *       ),
    *      @OA\Response(
    *          response=404,
    *          description="Client non trouvé",
    *       ),
    *      @OA\Response(
    *          response=400,
    *          description="Erreur lors de la récupération des tâches",
    *       ),
    *     )
    */
    function getTasksByClient($id){
        $client = Client::find($id);
        if ($client) {
            $tasks = $client->tasks;
            return ResponseController::response(true, 'Tâches récupérées avec succès', $tasks, 200);
        } else {
            return ResponseController::response(false, 'Client non trouvé', null, 404);
        }
    }
    /**
    *@OA\Get(
    *      path="/api/v1/clients/{id}/tasks/{task_id}",
    *      tags={"Clients",},
    *      summary="Détails d'une tâche d'un client",
    *      @OA\Parameter(
    *          name="id",
    *          in="path",
    *          required=true,
    *          description="ID du client",
    *          @OA\Schema(
    *              type="integer"
    *          )
    *      ),
    *      @OA\Parameter(
    *          name="task_id",
    *          in="path",
    *          required=true,
    *          description="ID de la tâche",
    *          @OA\Schema(
    *              type="integer"
    *          )
    *      ),
    *      @OA\Response(
    *          response=200,
    *          description="Tâche récupérée avec succès",
    *       ),
    *      @OA\Response(
    *          response=404,
    *          description="Client ou tâche non trouvé",
    *       ),
    *      @OA\Response(
    *          response=400,
    *          description="Erreur lors de la récupération de la tâche",
    *       ),
    *     )
    */
    function getTask($id, $task_id){
        $client = Client::find($id);
        if ($client) {
            $task = $client->tasks()->find($task_id);
            if ($task) {
                return ResponseController::response(true, 'Tâche récupérée avec succès', $task, 200);
            } else {
                return ResponseController::response(false, 'Tâche non trouvée', null, 404);
            }
        } else {
            return ResponseController::response(false, 'Client non trouvé', null, 404);
        }
    }
    /**
    *@OA\Get(
    *      path="/api/v1/clients/{id}/tasks/{task_id}/update",
    *      tags={"Clients",},
    *      summary="Mettre à jour une tâche d'un client",
    *      @OA\Parameter(
    *          name="id",
    *          in="path",
    *          required=true,
    *          description="ID du client",
    *          @OA\Schema(
    *              type="integer"
    *          )
    *      ),
    *      @OA\Parameter(
    *          name="task_id",
    *          in="path",
    *          required=true,
    *          description="ID de la tâche",
    *          @OA\Schema(
    *              type="integer"
    *          )
    *      ),
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(
    *              required={"name",},
    *              @OA\Property(property="name", type="string", example="Task Name"),
    *              @OA\Property(property="description", type="string", example=""),
    *              @OA\Property(property="status", type="integer", example="1"),
    *              @OA\Property(property="priority", type="integer", example="1"),
    *              @OA\Property(property="due_date", type="string", format="date-time", example="2023-10-01T00:00:00Z"),
    *              @OA\Property(property="assigned_to", type="integer", example="1"),
    *              @OA\Property(property="project_id", type="integer", example="1"),
    *          )
    *      ),
    *      @OA\Response(
    *          response=200,
    *          description="Tâche mise à jour avec succès",
    *       ),
    *      @OA\Response(
    *          response=404,
    *          description="Client ou tâche non trouvé",
    *       ),
    *      @OA\Response(
    *          response=400,
    *          description="Erreur lors de la mise à jour de la tâche",
    *       ),
    *     )
    */
    function updateTask(Request $request, $id, $task_id){
        $client = Client::find($id);
        if ($client) {
            $task = $client->tasks()->find($task_id);
            if ($task) {
                $task->name = $request->name;
                $task->description = $request->description;
                $task->status = $request->status;
                $task->priority = $request->priority;
                $task->due_date = $request->due_date;
                $task->assigned_to = $request->assigned_to;
                $task->project_id = $request->project_id;

                if ($task->save()) {
                    return ResponseController::response(true, 'Tâche mise à jour avec succès', null, 200);
                } else {
                    return ResponseController::response(false, 'Erreur lors de la mise à jour de la tâche', null, 400);
                }
            } else {
                return ResponseController::response(false, 'Tâche non trouvée', null, 404);
            }
        } else {
            return ResponseController::response(false, 'Client non trouvé', null, 404);
        }
    }
    /**
    *@OA\Delete(
    *      path="/api/v1/clients/{id}/tasks/{task_id}",
    *      tags={"Clients",},
    *      summary="Supprimer une tâche d'un client",
    *      @OA\Parameter(
    *          name="id",
    *          in="path",
    *          required=true,
    *          description="ID du client",
    *          @OA\Schema(
    *              type="integer"
    *          )
    *      ),
    *      @OA\Parameter(
    *          name="task_id",
    *          in="path",
    *          required=true,
    *          description="ID de la tâche",
    *          @OA\Schema(
    *              type="integer"
    *          )
    *      ),
    *      @OA\Response(
    *          response=200,
    *          description="Tâche supprimée avec succès",
    *       ),
    *      @OA\Response(
    *          response=404,
    *          description="Client ou tâche non trouvé",
    *       ),
    *      @OA\Response(
    *          response=400,
    *          description="Erreur lors de la suppression de la tâche",
    *       ),
    *     )
    */
    function destroyTask($id, $task_id){
        $client = Client::find($id);
        if ($client) {
            $task = $client->tasks()->find($task_id);
            if ($task) {
                if ($task->delete()) {
                    return ResponseController::response(true, 'Tâche supprimée avec succès', null, 200);
                } else {
                    return ResponseController::response(false, 'Erreur lors de la suppression de la tâche', null, 400);
                }
            } else {
                return ResponseController::response(false, 'Tâche non trouvée', null, 404);
            }
        } else {
            return ResponseController::response(false, 'Client non trouvé', null, 404);
        }
    }


}
