<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseController;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
    *@OA\Get(
    *      path="/api/v1/transactions",
    *      tags={"Transactions",},
    *      summary="Liste des transactions",
    *      @OA\Response(
    *          response=200,
    *          description="Transactions récupérés avec succès",
    *       ),
    *     )
    */
    function get_transactions(){
        $transactions = Transaction::all();
        return ResponseController::response(true, 'Les transactions ont été récupérés avec succès', $transactions);
    }

}
