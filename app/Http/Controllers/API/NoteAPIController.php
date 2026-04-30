<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseController;
use App\Models\ProjetNote;
use Illuminate\Http\Request;

class NoteAPIController extends Controller
{
    /**
    *@OA\Get(
    *      path="/api/v1/projet_notes",
    *      tags={"Notes de projets",},
    *      summary="Liste des notes",
    *      @OA\Response(
    *          response=200,
    *          description="Notes récupérées avec succès",
    *       ),
    *     )
    */
    function index(){
         $notes = ProjetNote::all();
         return ResponseController::response(true, 'Les notes ont été récupérées avec succès', $notes);
    }

    /**
     *@OA\Get(
     *      path="/api/v1/projet_notes/{id}",
     *      tags={"Note de projet",},
     *      summary="Liste des notes",
     *      @OA\Response(
     *          response=200,
     *          description="Notes récupérées avec succès",
     *       ),
     *          @OA\Parameter(
     *          description="Recherche par nom ou référence",
     *          in="path",
     *          name="id",
     *          required=false,
     *          @OA\Schema(type="string"),
     *          @OA\Examples(example="string", value="1", summary="a string value"),
     *      ),
     *     )
     */
    function show($id){
        $note = ProjetNote::find($id);

        if (!$note) {
            return ResponseController::response(false, 'Note non trouvée', null, 404);
        }

        return ResponseController::response(true, 'La note a été récupérée avec succès', $note);
    }

    /**
     *@OA\Get(
     *      path="/api/v1/get_projet_notes/{projet_id}",
     *      tags={"Note de projet",},
     *      summary="Liste des notes d'un projet",
     *      @OA\Response(
     *          response=200,
     *          description="Notes récupérées avec succès",
     *       ),
     *          @OA\Parameter(
     *          description="ID du projet",
     *          in="path",
     *          name="projet_id",
     *          required=false,
     *          @OA\Schema(type="string"),
     *          @OA\Examples(example="string", value="1", summary="a string value"),
     *      ),
     *     )
     */
    function get_projet_notes($projet_id)
    {
        $notes = ProjetNote::where('projet_id', $projet_id)->get();

         if ($notes->isEmpty()) {
            return ResponseController::response(false, 'Aucune note trouvée pour ce projet', null, 404);
        }

        return ResponseController::response(true, 'Les notes ont été récupérées avec succès', $notes);
    }


}
