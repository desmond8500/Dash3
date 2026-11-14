<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseController;
use App\Http\Resources\ArticleDocumentResource;
use App\Http\Resources\ArticleImageResource;
use App\Http\Resources\ArticleLinkResource;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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

        // Filtres de la page Articles (comme le panneau latéral de Dash3)
        foreach (['brand_id', 'provider_id', 'priority_id'] as $filter) {
            if ($request->filled($filter)) {
                $query->where($filter, $request->input($filter));
            }
        }

        $articles = $query
            ->with(['brand:id,name', 'provider:id,name'])
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

    public function show(int $id)
    {
        $article = Article::find($id);

        if ($article) {
            $article = new ArticleResource($article);
            return ResponseController::response(true, "L'article a été récupéré", $article);
        } else {
            return ResponseController::response(false, "L'article n'a pas été trouvé", []);
        }



    }

    /**
     * @OA\Get(
     *      path="/api/v1/items_image/{article_id}",
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
        if ($article) {
            $images = $article->images();

            $img_list = [];
            $i = 1;
            foreach ($images as $image) {
                $img_list[] = (object)array(
                    'id' => $i,
                    'image' => url("storage/$image"),
                );
                $i++;
            }

            return ResponseController::response(true, "Les images de l'article ont été récupérées", $img_list);
        } else {
            return ResponseController::response(false, "L'article n'a pas été trouvé", []);
        }

    }

    /**
     * @OA\Get(
     *      path="/api/v1/items_link/{article_id}",
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
     *      path="/api/v1/items_document/{article_id}",
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

    /**
     * Règles de validation communes à la création et à la modification.
     */
    private function rules(): array
    {
        return [
            'designation' => ['required', 'string', 'max:255'],
            'reference' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'spec' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'quantity' => ['nullable', 'integer', 'min:0'],
            'quantity_min' => ['nullable', 'integer', 'min:0'],
            'priority_id' => ['nullable', 'integer', 'between:0,7'],
            'weight' => ['nullable', 'numeric', 'min:0'],
            'tva' => ['nullable', 'numeric', 'min:0'],
            'brand_id' => ['nullable', 'integer', Rule::exists('brands', 'id')],
            'provider_id' => ['nullable', 'integer', Rule::exists('providers', 'id')],
        ];
    }

    /**
     * Les colonnes quantity, quantity_min et price ne sont pas nullables.
     */
    private function normalize(array $data): array
    {
        foreach (['quantity', 'quantity_min', 'price'] as $field) {
            if (array_key_exists($field, $data) && $data[$field] === null) {
                $data[$field] = 0;
            }
        }
        $data['designation'] = ucfirst($data['designation']);

        return $data;
    }

    /**
     * @OA\Post(
     *      path="/api/v1/items",
     *      tags={"Articles"},
     *      summary="Créer un article",
     *      security={{"sanctum":{}}},
     *      @OA\Response(response=201, description="Article créé"),
     *      @OA\Response(response=422, description="Données invalides")
     * )
     */
    public function store(Request $request)
    {
        $data = $this->normalize($request->validate($this->rules()));

        $article = Article::create($data + ['priority_id' => 1]);

        return response()->json([
            'success' => true,
            'message' => "L'article a été créé",
            'data' => new ArticleResource($article->fresh()),
            'meta' => null,
        ], 201);
    }

    /**
     * @OA\Put(
     *      path="/api/v1/items/{id}",
     *      tags={"Articles"},
     *      summary="Modifier un article",
     *      security={{"sanctum":{}}},
     *      @OA\Response(response=200, description="Article modifié"),
     *      @OA\Response(response=404, description="Article introuvable"),
     *      @OA\Response(response=422, description="Données invalides")
     * )
     */
    public function update(Request $request, int $id)
    {
        $article = Article::find($id);
        if (! $article) {
            return response()->json(['success' => false, 'message' => "L'article n'a pas été trouvé", 'error' => null, 'meta' => null], 404);
        }

        $article->update($this->normalize($request->validate($this->rules())));

        return ResponseController::response(true, "L'article a été modifié", new ArticleResource($article->fresh()));
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/items/{id}",
     *      tags={"Articles"},
     *      summary="Supprimer un article",
     *      security={{"sanctum":{}}},
     *      @OA\Response(response=200, description="Article supprimé"),
     *      @OA\Response(response=404, description="Article introuvable")
     * )
     */
    public function destroy(int $id)
    {
        $article = Article::find($id);
        if (! $article) {
            return response()->json(['success' => false, 'message' => "L'article n'a pas été trouvé", 'error' => null, 'meta' => null], 404);
        }

        $article->delete();

        return ResponseController::response(true, "L'article a été supprimé", null);
    }
}
