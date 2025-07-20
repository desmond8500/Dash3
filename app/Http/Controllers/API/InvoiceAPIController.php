<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseController;
use App\Http\Resources\FactureResource;
use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;
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
    public function index()
    {
        $invoices = Invoice::all();
        $invoices = InvoiceResource::collection($invoices);

        return ResponseController::response(true, "Les devis ont été récupérés", $invoices);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
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
        $invoices = FactureResource::collection($invoices);


        return ResponseController::response(true, "Les dépenses du mois ont été récupérées", $invoices);
    }
}
