<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseController;
use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;
use App\Models\InvoiceAcompte;
use Illuminate\Http\Request;

class InvoiceAPIController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/v1/invoices",
     *      tags={"Invoices"},
     *      description="Liste des devis",
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *       ),
     *     )
     */
    public function index(Request $request)
    {
        // Sans paramètre : comportement historique (tous les devis).
        // Avec ?search= ou ?per_page= : liste filtrée et paginée.
        if (! $request->filled('search') && ! $request->filled('per_page')) {
            $invoices = InvoiceResource::collection(Invoice::all());

            return ResponseController::response(true, "Tous les devis ont été récupérés", $invoices);
        }

        $perPage = min((int) $request->get('per_page', 20), 100);
        $search = $request->search;

        $invoices = Invoice::query()
            ->with('projet.client')
            ->when($search, function ($q) use ($search) {
                $q->where(function ($q) use ($search) {
                    $q->where('reference', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhere('client_name', 'like', "%{$search}%")
                        ->orWhere('projet_name', 'like', "%{$search}%")
                        ->orWhereHas('projet', fn ($p) => $p->where('name', 'like', "%{$search}%"))
                        ->orWhereHas('projet.client', fn ($c) => $c->where('name', 'like', "%{$search}%"));
                });
            })
            ->latest()
            ->paginate($perPage);

        return ResponseController::response(true, "Les devis ont été récupérés", InvoiceResource::collection($invoices), [
            'current_page' => $invoices->currentPage(),
            'last_page' => $invoices->lastPage(),
            'per_page' => $invoices->perPage(),
            'total' => $invoices->total(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * @OA\Get(
     *      path="/api/v1/invoices/{id}",
     *      tags={"Invoices"},
     *      summary="Détail d'un devis : sections, lignes et totaux",
     *      security={{"sanctum":{}}},
     *      @OA\Response(response=200, description="Success"),
     *      @OA\Response(response=404, description="Devis introuvable")
     * )
     */
    public function show(int $id)
    {
        $invoice = Invoice::with(['projet.client', 'sections.rows.article:id,image', 'acomptes', 'spents', 'documents'])->find($id);
        if (! $invoice) {
            return response()->json(['success' => false, 'message' => "Le devis n'a pas été trouvé", 'error' => null, 'meta' => null], 404);
        }

        $sections = $invoice->sections->sortBy('ordre')->values()->map(function ($section) {
            $rows = $section->rows->sortBy('priorite_id')->map(fn ($row) => [
                'id' => $row->id,
                'invoice_section_id' => $row->invoice_section_id,
                'article_id' => $row->article_id,
                'priorite_id' => $row->priorite_id,
                'designation' => $row->designation,
                'reference' => $row->reference,
                'quantite' => (float) $row->quantite,
                'coef' => (float) $row->coef,
                'prix' => (float) $row->prix,
                'bought' => (float) $row->bought,
                'total' => (float) $row->quantite * (float) $row->coef * (float) $row->prix,
                'comment' => $row->comment,
                'image' => $row->article?->image ? url($row->article->image) : null,
            ])->values();

            return [
                'id' => $section->id,
                'section' => $section->section,
                'ordre' => $section->ordre,
                'proposition' => $section->proposition,
                'show' => (bool) $section->show,
                'status' => (bool) $section->status,
                'rows' => $rows,
                'total' => $rows->sum('total'),
            ];
        });

        $data = (new InvoiceResource($invoice))->resolve();
        $data['sections'] = $sections;
        $data['acompte_total'] = (float) $invoice->acomptes->sum('montant');
        $data['spent_total'] = (float) $invoice->spents->sum('montant');
        $data['client_id'] = $invoice->projet?->client_id;
        $data['created_at'] = $invoice->created_at;
        $data['documents'] = $invoice->documents->map(fn ($d) => ['id' => $d->id, 'name' => $d->name, 'type' => $d->type, 'url' => $d->file ? url($d->file) : null])->values();
        $data['statuses'] = array_values((array) \App\Http\Controllers\InvoiceController::statut());

        return ResponseController::response(true, 'Le devis a été récupéré', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $invoice = Invoice::find($id);
        if (! $invoice) {
            return response()->json(['success' => false, 'message' => "Le devis n'a pas été trouvé", 'error' => null, 'meta' => null], 404);
        }
        $statuses = array_values((array) \App\Http\Controllers\InvoiceController::statut());
        $invoice->update($request->validate([
            'reference' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['sometimes', 'nullable', 'string'],
            'modalite' => ['sometimes', 'nullable', 'string'],
            'note' => ['sometimes', 'nullable', 'string'],
            'statut' => ['sometimes', 'required', 'string', \Illuminate\Validation\Rule::in($statuses)],
            'tax' => ['sometimes', 'nullable', 'string', \Illuminate\Validation\Rule::in(['tva', 'brs', ''])],
            'remise' => ['sometimes', 'nullable', 'numeric', 'min:0'],
            'facture_date' => ['sometimes', 'nullable', 'date'],
            'paydate' => ['sometimes', 'nullable', 'date'],
        ]));

        return $this->show((int) $id);
    }

    /**
     * @OA\Post(path="/api/v1/invoices/{id}/favorite", tags={"Invoices"}, summary="Ajouter / retirer des favoris",
     *      security={{"sanctum":{}}}, @OA\Response(response=200, description="Favori mis à jour"))
     */
    public function toggleFavorite(int $id)
    {
        $invoice = Invoice::find($id);
        if (! $invoice) {
            return response()->json(['success' => false, 'message' => "Le devis n'a pas été trouvé", 'error' => null, 'meta' => null], 404);
        }
        $invoice->favorite = ! $invoice->favorite;
        $invoice->save();

        return ResponseController::response(true, 'Favori mis à jour', ['favorite' => (bool) $invoice->favorite]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * @OA\Post(
     *      path="/api/v1/get_month_invoices",
     *      tags={"Invoices"},
     *      description="Récupérer les factures du mois",
     *
     *      @OA\RequestBody(
     *          required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                  @OA\Property(property="month", type="int"),
     *                  @OA\Property(property="year", type="int"),
     *                  required={"month", "year"}
     *             )
     *         )
     *      ),
     *      @OA\Response(response=200, description="Utilisateurs récupérés avec succès"),
     *      @OA\Response(response=401, description="Unauthorized")
     * )
     */
    function get_month_invoices(Request $request)
    {
        $month = $request->month;
        $year = $request->year;

        $invoices = Invoice::whereMonth('facture_date', $month)->whereYear('facture_date', $year)->get();
        $invoices = InvoiceResource::collection($invoices);

        return ResponseController::response(true, "Les factures du mois ont été récupérées", $invoices);
    }

    /**
     * @OA\Post(
     *      path="/api/v1/get_month_spents",
     *      tags={"Invoices"},
     *      description="Récupérer les factures du mois",
     *
     *      @OA\RequestBody(
     *          required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                  @OA\Property(property="month", type="int"),
     *                  @OA\Property(property="year", type="int"),
     *                  required={"month", "year"}
     *             )
     *         )
     *      ),
     *      @OA\Response(response=200, description="Utilisateurs récupérés avec succès"),
     *      @OA\Response(response=401, description="Unauthorized")
     * )
     */
    function get_month_spents(Request $request)
    {
        $month = $request->month;
        $year = $request->year;

        $invoices = Invoice::whereMonth('facture_date', $month)->whereYear('facture_date', $year)->get();
        $invoices = InvoiceResource::collection($invoices);

        return ResponseController::response(true, "Les dépenses du mois ont été récupérées", $invoices);
    }

    /**
     * @OA\Post(
     *      path="/api/v1/paid_invoices",
     *      tags={"Invoices"},
     *      description="Récupérer les factures soldées du mois",
     *
     *      @OA\RequestBody(
     *          required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                  @OA\Property(property="month", type="int"),
     *                  @OA\Property(property="year", type="int"),
     *                  required={"month", "year"}
     *             )
     *         )
     *      ),
     *      @OA\Response(response=200, description="Utilisateurs récupérés avec succès"),
     *      @OA\Response(response=401, description="Unauthorized")
     * )
     */
    function paid_invoices(Request $request)
    {
        $month = $request->month;
        $year = $request->year;
        if (!$year) {
            $year = 2025;
        }

        if ($month){
            $invoices = Invoice::orderBy('paydate')->where('paydate','!=',null)->whereMonth('paydate', $month)->whereYear('paydate', $year)->get();
        }else{
            $invoices = Invoice::orderBy('paydate')->where('paydate','!=',null)->whereYear('paydate', $year ?? 2025)->get();
        }
        $invoices = InvoiceResource::collection($invoices);


        return ResponseController::response(true, "Les dépenses du mois ont été récupérées", $invoices);
    }

    /**
     * @OA\Post(
     *      path="/api/v1/get_month_invoices_deposit",
     *      tags={"Invoices"},
     *      description="Récupérer les factures d'acompte non soldées de l'année",
     *
     *      @OA\RequestBody(
     *          required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                  @OA\Property(property="month", type="int"),
     *                  @OA\Property(property="year", type="int"),
     *                  required={"month", "year"}
     *             )
     *         )
     *      ),
     *      @OA\Response(response=200, description="les factures d'acompte récupérées avec succès"),
     *      @OA\Response(response=401, description="Unauthorized")
     * )
     */
    function get_month_invoices_deposit(Request $request)
    {
        $month = $request->month;
        $year = $request->year;

        // $invoices = Invoice::whereMonth('facture_date', $month)->whereNull('facture_date')->whereHas('acomptes')->get();
        $invoices = Invoice::where(function ($q) {
            $q->whereNull('paydate')
                ->orWhere('paydate', '');
            })
            // ->whereMonth('paydate', $month)
            // ->whereYear('paydate', $year)
            ->whereHas('acomptes')
            ->get();
        $invoices = InvoiceResource::collection($invoices);

        return ResponseController::response(true, "Les factures du mois ont été récupérées", $invoices);
    }

    /**
     * @OA\Post(
     *      path="/api/v1/annual_paid_invoices",
     *      tags={"Invoices"},
     *      description="Récupérer les factures soldées de l'année",
     *
     *      @OA\RequestBody(
     *          required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                  @OA\Property(property="year", type="int"),
     *                  required={"year"}
     *             )
     *         )
     *      ),
     *      @OA\Response(response=200, description="Utilisateurs récupérés avec succès"),
     *      @OA\Response(response=401, description="Unauthorized")
     * )
     */
    function annual_paid_invoices(Request $request)
    {
        $year = $request->input('year', now()->year);

        $invoices = Invoice::whereNotNull('paydate')
            ->whereYear('paydate', $year)
            ->orderBy('paydate')
            ->get();

        $data = [
            'year'       => $year,
            'total_paid' => $invoices->sum('montant'),
            'invoices'   => InvoiceResource::collection($invoices),
        ];

        return ResponseController::response(true, "Les factures de l'année ont été récupérées", $data);
    }

    /**
     * @OA\Post(
     *      path="/api/v1/get_annual_invoices_deposit",
     *      tags={"Invoices"},
     *      description="Récupérer les factures d'acompte non soldées de l'année",
     *
     *      @OA\RequestBody(
     *          required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                  @OA\Property(property="year", type="int"),
     *                  required={"year"}
     *             )
     *         )
     *      ),
     *      @OA\Response(response=200, description="les factures d'acompte récupérées avec succès"),
     *      @OA\Response(response=401, description="Unauthorized")
     * )
     */
    function get_annual_invoices_deposit(Request $request)
    {
        $year = $request->input('year', now()->year);

        $invoices = Invoice::with('acomptes')
            ->whereHas('acomptes', fn($q) => $q->where('statut', true))
            ->whereYear('created_at', $year)
            ->get();

        // $totalPaid = $invoices->sum(
        //     fn($invoice) => $invoice->acomptes
        //         ->where('statut', true)
        //         ->sum('montant')
        // );

        $totalPaid = InvoiceAcompte::where('statut', true)
            ->whereHas('invoice', function ($q) use ($year) {
                $q->where(function ($q2) {
                    $q2->whereNull('paydate')
                        ->orWhere('paydate', '');
                })
                    ->whereYear('created_at', $year); // ou date facture
            })
            ->sum('montant');

        return ResponseController::response(true, "Dépôts récupérés", [
            'year' => $year,
            'total_paid' => $totalPaid,
            'invoices' => InvoiceResource::collection($invoices),
        ]);
    }
}
