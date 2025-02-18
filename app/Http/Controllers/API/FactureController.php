<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseController;
use App\Http\Resources\FactureResource;
use App\Models\Facture;
use Illuminate\Http\Request;

class FactureController extends Controller
{
    function get_factures(){
        $factures = Facture::all();
        $factures = FactureResource::collection($factures);

        return ResponseController::response(true, "Les factures ont été récupérées", $factures);
    }
}
