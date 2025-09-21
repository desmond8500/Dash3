<?php

namespace App\Http\Controllers;

use App\Http\Resources\WebpageCategoryResource;
use App\Models\WebpageCategory;
use Illuminate\Http\Request;

class LiensControlleur extends Controller
{
    /**
     *@OA\Get(
     *      path="/api/v1/liens",
     *      tags={"Liens utiles",},
     *      summary="Liste des liens vers des ressources",
     *      @OA\Response(
     *          response=200,
     *          description="Liste des catégories",
     *       ),
     *     )
     */

    public function index()
    {
        // $categories = WebpageCategory::with('webpages')->get();
        $categories = WebpageCategory::all();
        $categories = WebpageCategoryResource::collection($categories);

        return ResponseController::response(true, 'Liste des catégories',$categories);
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
