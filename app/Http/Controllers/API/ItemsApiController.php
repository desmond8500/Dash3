<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseController;
use App\Http\Resources\ArticleDocumentResource;
use App\Http\Resources\ArticleImageResource;
use App\Http\Resources\ArticleLinkResource;
use App\Models\Article;
use App\Models\Commande;
use Spatie\Tags\Tag;
use App\Models\ArticleDependence;
use Illuminate\Support\Facades\Storage;
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
        // Type d'article (tags spatie de type stock_article)
        if ($request->filled('type')) {
            $query->withAnyTags([$request->input('type')], 'stock_article');
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
            $data = (new ArticleResource($article->load(['brand:id,name', 'provider:id,name'])))->resolve();
            $data['tags'] = $article->tags->pluck('name')->map(fn ($n) => ucfirst($n))->sort()->values();
            return ResponseController::response(true, "L'article a été récupéré", $data);
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
                    'path' => $image,
                    'is_default' => $article->image === "storage/$image",
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

    /**
     * @OA\Get(
     *      path="/api/v1/items_types",
     *      tags={"Articles"},
     *      summary="Types d'articles (filtre Types de la page Articles)",
     *      security={{"sanctum":{}}},
     *      @OA\Response(response=200, description="Success")
     * )
     */
    public function getTypes()
    {
        $types = Tag::getWithType('stock_article')
            ->map(fn ($tag) => ['id' => $tag->id, 'name' => $tag->name])
            ->sortBy('name')
            ->values();

        return ResponseController::response(true, "Les types d'articles ont été récupérés", $types);
    }

    /**
     * @OA\Post(
     *      path="/api/v1/items/{id}/commande",
     *      tags={"Articles"},
     *      summary="Commander un article (action Commander de la page Articles)",
     *      security={{"sanctum":{}}},
     *      @OA\Response(response=201, description="Commande créée")
     * )
     */
    public function commander(Request $request, int $id)
    {
        if (! Article::whereKey($id)->exists()) {
            return response()->json(['success' => false, 'message' => "L'article n'a pas été trouvé", 'error' => null, 'meta' => null], 404);
        }
        $data = $request->validate(['quantity' => ['nullable', 'integer', 'min:1']]);

        $commande = Commande::create([
            'article_id' => $id,
            'quantity' => $data['quantity'] ?? 1,
        ]);

        return response()->json(['success' => true, 'message' => 'Article ajouté aux commandes', 'data' => $commande, 'meta' => null], 201);
    }

    // ---------- Page article (comme livewire/stock/article-page) ----------

    private function articleOr404(int $id)
    {
        return Article::find($id);
    }

    private function notFoundJson()
    {
        return response()->json(['success' => false, 'message' => "L'article n'a pas été trouvé", 'error' => null, 'meta' => null], 404);
    }

    /** Vérifie qu'un chemin d'image appartient bien au dossier de l'article */
    private function safeImagePath(Article $article, ?string $path): ?string
    {
        $dir = "stock/articles/{$article->id}/images/";
        if (! $path || str_contains($path, '..') || ! str_starts_with($path, $dir)) {
            return null;
        }
        return $path;
    }

    /**
     * @OA\Post(path="/api/v1/items/{id}/quantity", tags={"Articles"}, summary="Ajuster la quantité (delta +1 / -1)",
     *      security={{"sanctum":{}}}, @OA\Response(response=200, description="Quantité mise à jour"))
     */
    public function adjustQuantity(Request $request, int $id)
    {
        $article = $this->articleOr404($id) ?? null;
        if (! $article) return $this->notFoundJson();
        $data = $request->validate(['delta' => ['required', 'integer', 'between:-1000,1000']]);
        $article->quantity = max(0, (int) $article->quantity + $data['delta']);
        $article->save();

        return ResponseController::response(true, 'Quantité mise à jour', ['quantity' => $article->quantity]);
    }

    /**
     * @OA\Post(path="/api/v1/items/{id}/tags", tags={"Articles"}, summary="Ajouter un tag (type d'article)",
     *      security={{"sanctum":{}}}, @OA\Response(response=200, description="Tag ajouté"))
     */
    public function attachTag(Request $request, int $id)
    {
        $article = $this->articleOr404($id);
        if (! $article) return $this->notFoundJson();
        $data = $request->validate(['name' => ['required', 'string', 'max:255']]);
        $tag = Tag::findOrCreate(strtolower(trim($data['name'])), 'stock_article');
        $article->attachTag($tag);

        return ResponseController::response(true, 'Tag ajouté', $article->fresh()->tags->pluck('name')->map(fn ($n) => ucfirst($n))->sort()->values());
    }

    /**
     * @OA\Delete(path="/api/v1/items/{id}/tags", tags={"Articles"}, summary="Retirer un tag (?name=)",
     *      security={{"sanctum":{}}}, @OA\Response(response=200, description="Tag retiré"))
     */
    public function detachTag(Request $request, int $id)
    {
        $article = $this->articleOr404($id);
        if (! $article) return $this->notFoundJson();
        $name = strtolower(trim((string) $request->query('name', '')));
        $tag = $article->tags->first(fn ($t) => strtolower($t->name) === $name);
        if ($tag) {
            $article->detachTag($tag);
        }

        return ResponseController::response(true, 'Tag retiré', $article->fresh()->tags->pluck('name')->map(fn ($n) => ucfirst($n))->sort()->values());
    }

    /**
     * @OA\Post(path="/api/v1/items/{id}/images", tags={"Articles"}, summary="Ajouter des images (multipart images[])",
     *      security={{"sanctum":{}}}, @OA\Response(response=200, description="Images ajoutées"))
     */
    public function storeImages(Request $request, int $id)
    {
        $article = $this->articleOr404($id);
        if (! $article) return $this->notFoundJson();
        $request->validate(['images' => ['required', 'array'], 'images.*' => ['image', 'max:6144']]);

        // Même dossier que la page web (ArticlePage::store_files)
        $dir = "stock/articles/{$article->id}/images";
        foreach ($request->file('images') as $photo) {
            $photo->storeAs("public/$dir", $photo->getClientOriginalName());
        }

        return $this->getImages((string) $article->id);
    }

    /**
     * @OA\Post(path="/api/v1/items/{id}/image-default", tags={"Articles"}, summary="Définir l'image par défaut (path)",
     *      security={{"sanctum":{}}}, @OA\Response(response=200, description="Image par défaut définie"))
     */
    public function setDefaultImage(Request $request, int $id)
    {
        $article = $this->articleOr404($id);
        if (! $article) return $this->notFoundJson();
        $path = $this->safeImagePath($article, $request->input('path'));
        if (! $path) {
            return response()->json(['success' => false, 'message' => 'Image invalide', 'error' => null, 'meta' => null], 422);
        }
        $article->image = "storage/$path";
        $article->save();

        return ResponseController::response(true, 'Image par défaut définie', ['image' => url($article->image)]);
    }

    /**
     * @OA\Delete(path="/api/v1/items/{id}/images", tags={"Articles"}, summary="Supprimer une image (?path=)",
     *      security={{"sanctum":{}}}, @OA\Response(response=200, description="Image supprimée"))
     */
    public function deleteImage(Request $request, int $id)
    {
        $article = $this->articleOr404($id);
        if (! $article) return $this->notFoundJson();
        $path = $this->safeImagePath($article, $request->query('path'));
        if (! $path) {
            return response()->json(['success' => false, 'message' => 'Image invalide', 'error' => null, 'meta' => null], 422);
        }
        Storage::disk('public')->delete($path);
        if ($article->image === "storage/$path") {
            $article->image = null;
            $article->save();
        }

        return $this->getImages((string) $article->id);
    }

    /**
     * @OA\Get(path="/api/v1/items/{id}/dependances", tags={"Articles"}, summary="Articles associés",
     *      security={{"sanctum":{}}}, @OA\Response(response=200, description="Success"))
     */
    public function getDependances(int $id)
    {
        $deps = ArticleDependence::with('dependence')
            ->where('article_id', $id)
            ->get()
            ->filter(fn ($d) => $d->dependence)
            ->map(fn ($d) => [
                'id' => $d->id,
                'quantity' => $d->quantity,
                'article' => (new ArticleResource($d->dependence))->resolve(),
            ])
            ->values();

        return ResponseController::response(true, 'Articles associés', $deps);
    }

    /**
     * @OA\Post(path="/api/v1/items/{id}/dependances", tags={"Articles"}, summary="Associer un article (dependence_id)",
     *      security={{"sanctum":{}}}, @OA\Response(response=201, description="Article associé"))
     */
    public function addDependance(Request $request, int $id)
    {
        if (! $this->articleOr404($id)) return $this->notFoundJson();
        $data = $request->validate(['dependence_id' => ['required', 'integer', 'exists:articles,id']]);
        if ((int) $data['dependence_id'] === $id) {
            return response()->json(['success' => false, 'message' => 'Un article ne peut pas dépendre de lui-même', 'error' => null, 'meta' => null], 422);
        }
        ArticleDependence::firstOrCreate(['article_id' => $id, 'dependence_id' => $data['dependence_id']], ['quantity' => 1]);

        return $this->getDependances($id);
    }

    /**
     * @OA\Post(path="/api/v1/dependances/{id}/quantity", tags={"Articles"}, summary="Quantité d'un article associé (delta)",
     *      security={{"sanctum":{}}}, @OA\Response(response=200, description="Quantité mise à jour"))
     */
    public function adjustDependance(Request $request, int $id)
    {
        $dep = ArticleDependence::find($id);
        if (! $dep) return response()->json(['success' => false, 'message' => 'Association introuvable', 'error' => null, 'meta' => null], 404);
        $data = $request->validate(['delta' => ['required', 'integer', 'between:-1000,1000']]);
        $dep->quantity = max(1, (int) $dep->quantity + $data['delta']);
        $dep->save();

        return ResponseController::response(true, 'Quantité mise à jour', ['quantity' => $dep->quantity]);
    }

    /**
     * @OA\Delete(path="/api/v1/dependances/{id}", tags={"Articles"}, summary="Retirer un article associé",
     *      security={{"sanctum":{}}}, @OA\Response(response=200, description="Association supprimée"))
     */
    public function removeDependance(int $id)
    {
        $dep = ArticleDependence::find($id);
        if ($dep) {
            $dep->delete();
        }

        return ResponseController::response(true, 'Association supprimée', null);
    }
}
