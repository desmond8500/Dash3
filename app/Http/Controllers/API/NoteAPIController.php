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
         $notes = ProjetNote::all()->with('projet');
         return ResponseController::response(true, 'Les notes ont été récupérées avec succès', $notes);
    }

    /**
    *@OA\Get(
    *      path="/api/v1/note",
    *      tags={"Note de projet",},
    *      summary="Liste des notes",
    *      @OA\Response(
    *          response=200,
    *          description="Notes récupérées avec succès",
    *       ),
    *     )
    */
    function show($id){
         $note = ProjetNote::find($id);
         return ResponseController::response(true, 'La note a été récupérée avec succès', $note);
    }




}
