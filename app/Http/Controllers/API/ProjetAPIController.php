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
     * @OA\Get(
     *     path="/api/v1/projets",
     *     operationId="getProjets",
     *     tags={"Projets"},
     *     summary="Liste des projets",
     *     description="Retourne la liste paginée des projets.",
     *
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         required=false,
     *         description="Recherche par nom du projet",
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\Parameter(
     *         name="client_id",
     *         in="query",
     *         required=false,
     *         description="Filtrer par client",
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Liste récupérée avec succès"
     *     )
     * )
     */
    public function index(Request $request)
    {
        $query = Projet::query();

        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        return ResponseController::response(
            true,
            'Projets récupérés avec succès',
            $query->latest()->paginate(20)
        );
    }

    /**
     * @OA\Post(
     *     path="/api/v1/projets",
     *     operationId="storeProjet",
     *     tags={"Projets"},
     *     summary="Créer un projet",
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"client_id","name"},
     *             @OA\Property(property="client_id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Installation Caméras Banque"),
     *             @OA\Property(property="description", type="string", example="Projet de vidéosurveillance."),
     *             @OA\Property(property="favorite", type="boolean", example=false)
     *         )
     *     ),
     *
     *     @OA\Response(response=201, description="Projet créé"),
     *     @OA\Response(response=422, description="Erreur de validation")
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => ['required', 'integer', 'exists:clients,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'favorite' => ['nullable', 'boolean'],
        ]);

        $projet = Projet::create($validated);

        return ResponseController::response(
            true,
            'Projet créé avec succès',
            $projet,
            201
        );
    }

    /**
     * @OA\Get(
     *     path="/api/v1/projets/{id}",
     *     operationId="showProjet",
     *     tags={"Projets"},
     *     summary="Afficher un projet",
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\Response(response=200, description="Projet trouvé"),
     *     @OA\Response(response=404, description="Projet introuvable")
     * )
     */
    public function show(int $id)
    {
        $projet = Projet::with([
            'client',
            'invoices',
            'buildings',
            'tasks',
            'journals',
            'contacts'
        ])->find($id);

        if (!$projet) {
            return ResponseController::response(
                false,
                'Projet non trouvé',
                null,
                404
            );
        }

        return ResponseController::response(
            true,
            'Projet récupéré avec succès',
            new ProjetResource($projet)
        );
    }

    /**
     * @OA\Put(
     *     path="/api/v1/projets/{id}",
     *     operationId="updateProjet",
     *     tags={"Projets"},
     *     summary="Modifier un projet",
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"client_id","name"},
     *             @OA\Property(property="client_id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Projet Banque Dakar"),
     *             @OA\Property(property="description", type="string", example="Mise à jour."),
     *             @OA\Property(property="favorite", type="boolean", example=true)
     *         )
     *     ),
     *
     *     @OA\Response(response=200, description="Projet modifié"),
     *     @OA\Response(response=404, description="Projet introuvable")
     * )
     */
    public function update(Request $request, int $id)
    {
        $projet = Projet::find($id);

        if (!$projet) {
            return ResponseController::response(false, 'Projet non trouvé', null, 404);
        }

        $validated = $request->validate([
            'client_id' => ['required', 'integer', 'exists:clients,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'favorite' => ['nullable', 'boolean'],
        ]);

        $projet->update($validated);

        return ResponseController::response(
            true,
            'Projet mis à jour avec succès',
            $projet
        );
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/projets/{id}",
     *     operationId="deleteProjet",
     *     tags={"Projets"},
     *     summary="Supprimer un projet",
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\Response(response=200, description="Projet supprimé"),
     *     @OA\Response(response=404, description="Projet introuvable")
     * )
     */
    public function destroy(int $id)
    {
        $projet = Projet::find($id);

        if (!$projet) {
            return ResponseController::response(false, 'Projet non trouvé', null, 404);
        }

        $projet->delete();

        return ResponseController::response(
            true,
            'Projet supprimé avec succès'
        );
    }

    /**
     * @OA\Get(
     *     path="/api/v1/projets/{id}/tasks",
     *     operationId="getProjetTasks",
     *     tags={"Projets","Tâches"},
     *     summary="Liste des tâches d'un projet",
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\Response(response=200, description="Liste des tâches"),
     *     @OA\Response(response=404, description="Projet introuvable")
     * )
     */
    public function getTasksByProjet(int $id)
    {
        $projet = Projet::find($id);

        if (!$projet) {
            return ResponseController::response(false, 'Projet non trouvé', null, 404);
        }

        return ResponseController::response(
            true,
            'Tâches récupérées avec succès',
            $projet->tasks()->orderBy('name')->get()
        );
    }
}
