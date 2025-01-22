<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseController;
use App\Models\Article;
use Illuminate\Http\Request;

/**
 * @OA\Info(version="1.0",
 * title="Dash Server API",
 * description="Api de l'application Dash")
 */


class ItemsApiController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/v1/items",
     *      tags={"Articles"},
     *      description="Liste des articles",
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *       ),
     *     )
     */
    function index(){
        $articles = Article::all();

        return ResponseController::response(true, "Les articles ont été récupérés",$articles);
    }
}
