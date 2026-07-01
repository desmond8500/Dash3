<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseController;
use App\Models\Journal;
use Illuminate\Http\Request;

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
        $journal = Journal::findOrFail($id);
        if ($journal) {
            return ResponseController::response(true, 'Le journal a été récupéré avec succès', $journal);
        } else {
            return ResponseController::response(false, 'Journal non trouvé', null, 404);
        }
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
        $journal = new Journal();
        $journal->user_id = $request->user_id;
        $journal->projet_id = $request->projet_id;
        $journal->devis_id = $request->devis_id;
        $journal->title = $request->title;
        $journal->date = $request->date;
        $journal->description = $request->description;
        $journal->type = $request->type;

        if ($journal->save()) {
            return ResponseController::response(true, 'Journal créé avec succès', $journal, 201);
        } else {
            return ResponseController::response(false, 'Erreur lors de la création du Journal', null, 400);
        }
    }

    /**
     *@OA\Put(
        *      path="/api/v1/journaux/{id}",
        *      tags={"Journaux",},
        *      summary="Mettre à jour un journal",
        *      @OA\Parameter(
        *          name="id",
        *          in="path",
        *          required=true,
        *          description="ID du journal",
        *          @OA\Schema(
        *              type="integer"
        *          )
        *      ),
        *      @OA\RequestBody(
        *          required=true,
        *          @OA\JsonContent(
        *              required={"title",},
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
        *          response=200,
        *          description="Journal mis à jour avec succès",
        *       ),
        *      @OA\Response(
        *          response=404,
        *          description="Journal non trouvé",
        *       ),
        *      @OA\Response(
        *          response=400,
        *          description="Erreur lors de la mise à jour du journal",
        *       ),
        *     )
        */
    function update(Request $request, int $id)
    {
        $journal = Journal::find($id);
        if ($journal) {
            $journal->user_id = $request->user_id;
            $journal->projet_id = $request->projet_id;
            $journal->devis_id = $request->devis_id;
            $journal->title = $request->title;
            $journal->date = $request->date;
            $journal->description = $request->description;
            $journal->type = $request->type;

            if ($journal->save()) {
                return ResponseController::response(true, 'Journal mis à jour avec succès', $journal, 200);
            } else {
                return ResponseController::response(false, 'Erreur lors de la mise à jour du journal', null, 400);
            }
        } else {
            return ResponseController::response(false, 'Journal non trouvé', null, 404);
        }
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

