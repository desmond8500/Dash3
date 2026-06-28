<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseController;
use App\Http\Resources\ProjetResource;
use App\Models\Projet;
use App\Models\Task;
use Illuminate\Http\Request;

class ProjetAPIController extends Controller
{
    /**
        *@OA\Get(
        *      path="/api/v1/projets",
        *      tags={"Projets",},
        *      summary="Liste des projets",
        *      @OA\Response(
        *          response=200,
        *          description="Utilisateurs récupérés avec succès",
        *       ),
        *      @OA\Parameter(
        *          name="search",
        *          in="path",
        *          required=false,
        *          description="Terme de recherche pour filtrer les projets par nom",
        *          ),
        *     )
    */
    public function index(Request $request)
    {   return 0;
        if($request->search) {
            $projets = Projet::with(['client', 'invoices', 'buildings', 'tasks', 'journals', 'contacts'])->where('name', 'like', '%' . $request->search . '%')->get();
        } else {
            $projets = Projet::with(['client', 'invoices', 'buildings', 'tasks', 'journals', 'contacts'])->get();
        }
        return ResponseController::response(true, 'Projets récupérés avec succès', $projets);
        // return ResponseController::response(true, 'Projets récupérés avec succès', ProjetResource::collection($projets));
    }

    /**
     *@OA\Post(
     *      path="/api/v1/projets",
     *      tags={"Projets",},
     *      summary="Ajouter un projet",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"name","client_id"},
     *              @OA\Property(property="client_id", type="integer", example="1"),
     *              @OA\Property(property="name", type="string", example="Projet Name"),
     *              @OA\Property(property="description", type="string", example=""),
     *              @OA\Property(property="favorite", type="string", example="1"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Projet créé avec succès",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Erreur lors de la création du projet",
     *       ),
     *     )
     */
    public function store(Request $request)
    {
        $projet = new Projet();
        $projet->client_id = $request->client_id;
        $projet->name = $request->name;
        $projet->description = $request->description;

        if ($projet->save()) {
            return ResponseController::response(true, 'Projet créé avec succès', $projet, 201);
        } else {
            return ResponseController::response(false, 'Erreur lors de la création du projet', null, 400);
        }
    }

    /**
        *@OA\Get(
        *      path="/api/v1/projets/{id}",
        *      tags={"Projets",},
        *      summary="Récupération d'un projet",
        *      @OA\Response(
        *          response=200,
        *          description="Projet récupéré avec succès",
        *       ),
        *      @OA\Parameter(
        *          name="id",
        *          in="path",
        *          required=true,
        *          description="ID du projet",
        *          ),
        *
        *     )
    */

    public function show(string $id)
    {
        $projet = Projet::with(['client', 'invoices', 'buildings', 'tasks', 'journals', 'contacts'])->find($id);

        $projet = new ProjetResource($projet);

        if (!$projet) {
            return ResponseController::response(false, 'Projet non trouvé', null);
        }
        return ResponseController::response(true, 'Projet récupéré avec succès', $projet);
        // return ResponseController::response(true, 'Projet récupéré avec succès', new ProjetResource($projet));
    }

    /**
     *@OA\Put(
     *      path="/api/v1/projets/{id}",
     *      tags={"Projets",},
     *      summary="Mettre à jour un projet",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID du projet",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *              @OA\JsonContent(
     *              required={"name","client_id"},
     *              @OA\Property(property="client_id", type="integer", example="1"),
     *              @OA\Property(property="name", type="string", example="Projet Name"),
     *              @OA\Property(property="description", type="string", example=""),
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
    public function update(Request $request, string $id)
    {
        $projet = Projet::find($id);
        if($projet){
            $projet->client_id = $request->client_id;
            $projet->name = $request->name;
            $projet->description = $request->description;
            if ($projet->save()) {
                return ResponseController::response(true, 'Projet mis à jour avec succès', $projet, 200);
            } else {
                return ResponseController::response(false, 'Erreur lors de la mise à jour du projet', null, 400);
            }
        } else {
            return ResponseController::response(false, 'Projet non trouvé', null, 404);
        }
    }

    /**
     *@OA\Delete(
     *      path="/api/v1/projets/{id}",
     *      tags={"Projets",},
     *      summary="Supprimer un projet",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID du projet",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Projet supprimé avec succès",
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Projet non trouvé",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Erreur lors de la suppression du projet",
     *       ),
     *     )
     */
    public function destroy(string $id)
    {
        $projet = Projet::find($id);
        if ($projet) {
            if ($projet->delete()) {
                return ResponseController::response(true, 'Projet supprimé avec succès', null, 200);
            } else {
                return ResponseController::response(false, 'Erreur lors de la suppression du Projet', null, 400);
            }
        } else {
            return ResponseController::response(false, 'Projet non trouvé', null, 404);
        }
    }

    /**
     *@OA\Get(
     *      path="/api/v1/projet/tasks/{id}",
     *      tags={"Projets","Taches"},
     *      summary="Liste des tâches d'un projet",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID du projet",
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
    function getTasksByProjet($id)
    {
        $projet = Projet::find($id);
        if ($projet) {
            $tasks = Task::where('projet_id', $id)->orderBy('name', 'asc')->get();
            return ResponseController::response(true, 'Tâches récupérées avec succès', $tasks, 200);
        } else {
            return ResponseController::response(false, 'projet non trouvé', null, 404);
        }
    }
}
