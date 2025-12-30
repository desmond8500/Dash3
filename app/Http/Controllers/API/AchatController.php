<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseController;
use App\Http\Resources\AchatResource;
use App\Models\Achat;
use Illuminate\Http\Request;

class AchatController extends Controller
{
    /**
         * @OA\Get(
         *      path="/api/v1/achats",
         *      tags={"Achats",},
         *      summary="Liste des achats",
         *      @OA\Response(
         *          response=200,
         *          description="les achats ont été récupérés avec succès",
         *       ),
         *     )
         */
    function get_achats(){
        $achats = Achat::all();

        $achats = AchatResource::collection($achats);

        return ResponseController::response(true, 'Les achats ont été récupérés avec succès', $achats);
    }
}
