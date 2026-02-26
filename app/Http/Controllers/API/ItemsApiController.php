<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseController;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Resources\ArticleResource;

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
    function index(Request $request){
        $perPage = min($request->get('per_page', 10), 100);
        $articles = Article::paginate($perPage);
        $articles = ArticleResource::collection($articles);

        return ResponseController::response(true, "Les articles ont été récupérés",$articles, [
            'current_page' => $articles->currentPage(),
            'last_page' => $articles->lastPage(),
            'per_page' => $articles->perPage(),
            'total' => $articles->total(),
        ]);
    }

    /**
     * @OA\Get(
     *      path="/api/v1/items/{id}",
     *      tags={"Articles"},
     *      description="afficher un article",
     *        @OA\Parameter(
     *          description="Parameter with example",
     *          in="path",
     *          name="id",
     *          required=true,
     *          @OA\Schema(type="integer"),
     *          @OA\Examples(example="int", value="1", summary="an int value"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *       ),
     *     )
     */

    public function show(string $id)
    {
        $article = Article::find($id);
        $article = new ArticleResource($article);

        return ResponseController::response(true, "L'article a été récupéré", $article);
    }
}
