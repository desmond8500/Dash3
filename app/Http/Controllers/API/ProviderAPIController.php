<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseController;
use App\Models\Provider;
use Illuminate\Http\Request;

class ProviderAPIController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/v1/providers",
     *      tags={"Fournisseurs"},
     *      description="Liste des fournisseurs",
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *       ),
     *     )
     */
    function index()
    {
        $provider = Provider::all();

        return ResponseController::response(true, "Les fournisseurs ont été récupérés", $provider);
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
}
