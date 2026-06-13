<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseController;
use App\Http\Resources\ClientResource;
use App\Http\Resources\InvoiceResource;
use App\Http\Resources\ProjetResource;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Projet;
use Illuminate\Http\Request;

class FavorisController extends Controller
{
    /**
    *@OA\Get(
    *      path="/api/v1/favoris",
    *      tags={"Favoris",},
    *      summary="Liste des favoris",
    *      @OA\Response(
    *          response=200,
    *          description="Favoris récupérés avec succès",
    *       ),
    *     )
    */

    public function getFavoris(){
        return ResponseController::response(true, 'Favoris retrieved successfully', [
            'clients' => ClientResource::collection(Client::favorite()),
            'projets' => ProjetResource::collection(Projet::favorite()),
            'invoices' => InvoiceResource::collection(Invoice::favorite()),
        ]);
    }
}
