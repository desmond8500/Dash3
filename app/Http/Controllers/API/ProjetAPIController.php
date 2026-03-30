<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseController;
use App\Models\Projet;
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        if (!$projet) {
            return ResponseController::response(false, 'Projet non trouvé', null);
        }
        return ResponseController::response(true, 'Projet récupéré avec succès', $projet);
        // return ResponseController::response(true, 'Projet récupéré avec succès', new ProjetResource($projet));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
