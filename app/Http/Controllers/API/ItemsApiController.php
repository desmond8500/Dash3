<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseController;
use App\Http\Resources\ArticleDocumentResource;
use App\Http\Resources\ArticleImageResource;
use App\Http\Resources\ArticleLinkResource;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Resources\ArticleResource;
use App\Models\ArticleDocument;
use App\Models\ArticleLink;

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
        $perPage = min((int) $request->get('per_page', 10), 100);

        $query = Article::query();

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('designation', 'like', "%{$search}%")
                    ->orWhere('reference', 'like', "%{$search}%");
            });
        }

        $articles = $query
            ->latest()
            ->paginate($perPage);

        $articles = ArticleResource::collection($articles);

        return ResponseController::response(
            true,
            "Les articles ont été récupérés",
            $articles,
            [
                'current_page' => $articles->currentPage(),
                'last_page' => $articles->lastPage(),
                'per_page' => $articles->perPage(),
                'total' => $articles->total(),
                'dimp' => [
                    $request->search,
                    $request->page,
                ]
            ]
        );
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

    /**
     * @OA\Get(
     *      path="/api/v1/item_image/{article_id}",
     *      tags={"Articles"},
     *      description="Récupérer les images d'un article",
     *      @OA\Parameter(
     *          description="ID de l'article",
     *          in="path",
     *          name="article_id",
     *          required=true,
     *          @OA\Schema(type="integer"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *       ),
     *     )
     */
    public function getImages(string $article_id)
    {
        $article = Article::find($article_id);
        $images = $article->images();

        $img_list = [];
        foreach ($images as $image) {
            $img_list[] = url($image);
        }

        return ResponseController::response(true, "Les images de l'article ont été récupérées", $img_list);
    }

    /**
     * @OA\Get(
     *      path="/api/v1/item_link/{article_id}",
     *      tags={"Articles"},
     *      description="Récupérer les liens d'un article",
     *      @OA\Parameter(
     *          description="ID de l'article",
     *          in="path",
     *          name="article_id",
     *          required=true,
     *          @OA\Schema(type="integer"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *       ),
     *     )
     */
    public function getLinks(string $article_id)
    {
        $links = ArticleLink::where('article_id', $article_id)->get();

        $links = ArticleLinkResource::collection($links);

        return ResponseController::response(true, "Les liens de l'article ont été récupérés", $links);
    }

    /**
     * @OA\Get(
     *      path="/api/v1/item_document/{article_id}",
     *      tags={"Articles"},
     *      description="Récupérer les documents d'un article",
     *      @OA\Parameter(
     *          description="ID de l'article",
     *          in="path",
     *          name="article_id",
     *          required=true,
     *          @OA\Schema(type="integer"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *       ),
     *     )
     */
    public function getDocuments(string $article_id)
    {
        $documents =  ArticleDocument::where('article_id', $article_id)->get();

        $documents = ArticleDocumentResource::collection($documents);

        return ResponseController::response(true, "Les documents de l'article ont été récupérés", $documents);
    }
}
