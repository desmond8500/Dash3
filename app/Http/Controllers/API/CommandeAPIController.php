<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseController;
use App\Models\Article;
use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/** Commandes d'articles (demandes de réapprovisionnement), fusionnées par article */
class CommandeAPIController extends Controller
{
    private function merged()
    {
        return Commande::query()
            ->select('article_id', DB::raw('SUM(quantity) as total_quantity'), DB::raw('COUNT(*) as demandes'))
            ->with(['article' => fn ($q) => $q->with(['brand:id,name', 'provider:id,name'])])
            ->groupBy('article_id')
            ->get()
            ->filter(fn ($c) => $c->article)
            ->map(fn ($c) => [
                'article_id' => $c->article_id,
                'quantity' => (int) $c->total_quantity,
                'demandes' => (int) $c->demandes,
                'article' => [
                    'id' => $c->article->id,
                    'designation' => $c->article->designation,
                    'reference' => $c->article->reference,
                    'image' => url($c->article->image ?? 'img/icons/no-camera.png'),
                    'price' => $c->article->price,
                    'quantity' => $c->article->quantity,
                    'quantity_min' => $c->article->quantity_min,
                    'brand_name' => $c->article->brand?->name,
                    'provider_name' => $c->article->provider?->name,
                ],
            ])
            ->values();
    }

    /** @OA\Get(path="/api/v1/commandes", tags={"Commandes"}, summary="Commandes fusionnées par article + articles sous le seuil", security={{"sanctum":{}}}, @OA\Response(response=200, description="Success")) */
    public function index()
    {
        $low = Article::whereRaw('`quantity` < `quantity_min`')
            ->orderBy('designation')
            ->get(['id', 'designation', 'reference', 'image', 'quantity', 'quantity_min', 'price'])
            ->map(function ($a) {
                $a->image = url($a->image ?? 'img/icons/no-camera.png');

                return $a;
            });

        return ResponseController::response(true, 'Commandes récupérées', [
            'commandes' => $this->merged(),
            'low_stock' => $low,
        ]);
    }

    /** @OA\Put(path="/api/v1/commandes/articles/{articleId}", tags={"Commandes"}, summary="Ajuster la quantité commandée d'un article (delta ou quantity)", security={{"sanctum":{}}}, @OA\Response(response=200, description="Modifiée")) */
    public function update(Request $request, int $articleId)
    {
        $data = $request->validate([
            'delta' => ['nullable', 'integer', 'between:-10000,10000'],
            'quantity' => ['nullable', 'integer', 'min:0'],
        ]);

        $total = (int) Commande::where('article_id', $articleId)->sum('quantity');
        $target = array_key_exists('quantity', $data) && $data['quantity'] !== null
            ? $data['quantity']
            : max(0, $total + ($data['delta'] ?? 0));

        // Les demandes sont fusionnées : on les remplace par une seule ligne au total voulu
        DB::transaction(function () use ($articleId, $target) {
            Commande::where('article_id', $articleId)->delete();
            if ($target > 0) {
                Commande::create(['article_id' => $articleId, 'quantity' => $target]);
            }
        });

        return ResponseController::response(true, 'Quantité modifiée', ['article_id' => $articleId, 'quantity' => $target]);
    }

    /** @OA\Delete(path="/api/v1/commandes/articles/{articleId}", tags={"Commandes"}, summary="Retirer un article des commandes", security={{"sanctum":{}}}, @OA\Response(response=200, description="Retiré")) */
    public function destroy(int $articleId)
    {
        Commande::where('article_id', $articleId)->delete();

        return ResponseController::response(true, 'Article retiré des commandes', null);
    }
}
