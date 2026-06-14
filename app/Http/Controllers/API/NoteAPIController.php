<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseController;
use App\Models\Projet;
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
     *      tags={"Notes de projets",},
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
     *      tags={"Notes de projets",},
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

    /**
     *@OA\Post(
     *      path="/api/v1/projet_notes",
     *      tags={"Notes de projets",},
     *      summary="Ajouter une note",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"titre",},
     *              @OA\Property(property="projet_id", type="integer", example="1"),
     *              @OA\Property(property="titre", type="Note 1"),
     *              @OA\Property(property="description", type="string", example="Mon super texte"),
     *               )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Note créée avec succès",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Erreur lors de la création de la note",
     *       ),
     *     )
     */

    public function store(Request $request){
        $note  = new ProjetNote();

        $note->projet_id = $request->projet_id;
        $note->titre = $request->titre;
        $note->description = $request->description;

        if ($note->save()) {
            return ResponseController::response(true, 'Note créée avec succès', null, 201);
        } else {
            return ResponseController::response(false, 'Erreur lors de la création de la note', null, 400);
        }
    }

    /**
     *@OA\Put(
     *      path="/api/v1/projet_notes/{id}",
     *      tags={"Notes de projets",},
     *      summary="Mettre à jour une note",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID de la note",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"titre",},
     *              @OA\Property(property="projet_id", type="integer", example="1"),
     *              @OA\Property(property="titre", type="Note 1"),
     *              @OA\Property(property="description", type="string", example="Mon super texte"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Note mise à jour avec succès",
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Note non trouvée",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Erreur lors de la mise à jour de la note",
     *       ),
     *     )
     */
    public function update(Request $request, $id){
        $note  = ProjetNote::find($id);

        if ($note) {
            $note->projet_id = $request->projet_id;
            $note->titre = $request->titre;
            $note->description = $request->description;

            if ($note->save()) {
                return ResponseController::response(true, 'Note mise à jour avec succès', null, 201);
            } else {
                return ResponseController::response(false, 'Erreur lors de la mise à jour de la note', null, 400);
                }
            } else {
            return ResponseController::response(false, 'Note non trouvée', null, 404);
        }
    }

    /**
     *@OA\Delete(
     *      path="/api/v1/projet_notes/{id}",
     *      tags={"Notes de projets",},
     *      summary="Supprimer une note",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID de la note",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Note supprimée avec succès",
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Note non trouvée",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Erreur lors de la suppression du Note",
     *       ),
     *     )
     */
    public function destroy($id)
    {
        $note  = ProjetNote::find($id);

        if ($note) {
            if ($note->delete()) {
                return ResponseController::response(true, 'Note supprimée avec succès', null, 200);
            } else {
                return ResponseController::response(false, 'Erreur lors de la suppression de la note', null, 400);
            }
        } else {
            return ResponseController::response(false, 'Note non trouvée');
        }

    }

}
