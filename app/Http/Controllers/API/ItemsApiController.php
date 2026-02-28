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
     *       @OA\Parameter(
     *          description="Recherche par nom ou référence",
     *          in="path",
     *          name="search",
     *          required=false,
     *          @OA\Schema(type="string"),
     *          @OA\Examples(example="string", value="test", summary="a string value"),
     *      ),
     *      @OA\Parameter(
     *          description="Page de pagination",
     *          in="path",
     *          name="page",
     *          required=false,
     *          @OA\Schema(type="string"),
     *          @OA\Examples(example="string", value="test", summary="a string value"),
     *      ),
     *      @OA\Parameter(
     *          description="Nombre d'éléments par page",
     *          in="path",
     *          name="per_page",
     *          required=false,
     *          @OA\Schema(type="string"),
     *          @OA\Examples(example="string", value="test", summary="a string value"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *       ),
     *     )
     */
    function index(Request $request){
        $perPage = min($request->get('per_page', 10), 100);

        if ($request->search) {
            $articles = Article::where('designation', 'like', '%' . $request->search . '%')
            ->orWhere('reference', 'like', '%' . $request->search . '%')
            ->paginate($perPage);
        } else {
            $articles = Article::paginate($perPage);
        }

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
     *      path="/api/v1/items/{article_id}",
     *      tags={"Articles"},
     *      description="afficher un article",
     *        @OA\Parameter(
     *          description="Parameter with example",
     *          in="path",
     *          name="article_id",
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

    public function show(string $article_id)
    {
        $article = Article::find($article_id);
        $article = new ArticleResource($article);

        return ResponseController::response(true, "L'article a été récupéré", $article);
    }
}
