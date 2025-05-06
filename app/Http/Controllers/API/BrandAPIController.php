<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseController;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandAPIController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/v1/brands",
     *      tags={"Marques"},
     *      description="Liste des marques",
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *       ),
     *     )
     */
    function index()
    {
        $brands = Brand::all();

        return ResponseController::response(true, "Les marques ont été récupérés", $brands);
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
