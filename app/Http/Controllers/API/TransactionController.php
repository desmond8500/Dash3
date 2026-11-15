<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseController;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/transactions",
     *     tags={"Transactions"},
     *     summary="Liste des transactions",
     *     security={{"sanctum":{}}},
     *
     *     @OA\Parameter(name="date", in="query", required=false,
     *         description="Date exacte (YYYY-MM-DD)",
     *         @OA\Schema(type="string", format="date", example="2026-10-31")),
     *
     *     @OA\Parameter(name="month", in="query", required=false,
     *         description="Mois (1 à 12)",
     *         @OA\Schema(type="integer", minimum=1, maximum=12, example=10)),
     *
     *     @OA\Parameter(name="year", in="query", required=false,
     *         description="Année",
     *         @OA\Schema(type="integer", example=2026)),
     *
     *     @OA\Parameter(name="user_id", in="query", required=false,
     *         description="Identifiant de l'utilisateur",
     *         @OA\Schema(type="integer", example=1)),
     *
     *     @OA\Parameter(name="per_page", in="query", required=false,
     *         description="Nombre d'éléments par page (1 à 100, défaut 15)",
     *         @OA\Schema(type="integer", default=15)),
     *
     *     @OA\Response(response=200, description="Transactions récupérées avec succès"),
     *     @OA\Response(response=401, description="Non authentifié"),
     *     @OA\Response(response=422, description="Paramètres invalides")
     * )
     */
    function get_transactions(Request $request){
        $validator = Validator::make($request->all(), [
            'date' => ['nullable', 'date_format:Y-m-d'],
            'month' => ['nullable', 'integer', 'between:1,12'],
            'year' => ['nullable', 'integer', 'digits:4'],
            'user_id' => ['nullable', 'integer', 'exists:users,id'],
            'per_page' => ['nullable', 'integer', 'between:1,100'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Les données fournies sont invalides.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $transactions = Transaction::query()
            ->when($filters['date'] ?? null,    fn($q, $v) => $q->whereDate('created_at', $v))
            ->when($filters['month'] ?? null,   fn($q, $v) => $q->whereMonth('created_at', $v))
            ->when($filters['year'] ?? null,    fn($q, $v) => $q->whereYear('created_at', $v))
            ->when($filters['user_id'] ?? null, fn($q, $v) => $q->where('user_id', $v))
            ->latest()
            ->paginate($filters['per_page'] ?? 15)
            ->withQueryString();

        return ResponseController::response(
            true,
            'Les transactions ont été récupérées avec succès',
            $transactions
        );
    }

}
