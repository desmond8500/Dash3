<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseController;
use App\Models\CV;
use Illuminate\Http\Request;

/** CV de l'utilisateur connecté */
class CvAPIController extends Controller
{
    /** @OA\Get(path="/api/v1/cvs", tags={"CV"}, summary="Mes CV", security={{"sanctum":{}}}, @OA\Response(response=200, description="Success")) */
    public function index(Request $request)
    {
        $cvs = CV::where('user_id', $request->user()->id)->latest()->get();

        return ResponseController::response(true, 'CV récupérés', $cvs);
    }

    /** @OA\Post(path="/api/v1/cvs", tags={"CV"}, summary="Créer un CV", security={{"sanctum":{}}}, @OA\Response(response=201, description="Créé")) */
    public function store(Request $request)
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:255']]);
        $cv = CV::create(['user_id' => $request->user()->id, 'name' => $data['name']]);

        return response()->json(['success' => true, 'message' => 'CV créé', 'data' => $cv, 'meta' => null], 201);
    }

    /** @OA\Put(path="/api/v1/cvs/{id}", tags={"CV"}, summary="Renommer un CV", security={{"sanctum":{}}}, @OA\Response(response=200, description="Modifié")) */
    public function update(Request $request, int $id)
    {
        $cv = CV::where('user_id', $request->user()->id)->find($id);
        if (! $cv) return ResponseController::response(false, 'CV non trouvé', null, 404);
        $cv->update($request->validate(['name' => ['required', 'string', 'max:255']]));

        return ResponseController::response(true, 'CV modifié', $cv);
    }

    /** @OA\Delete(path="/api/v1/cvs/{id}", tags={"CV"}, summary="Supprimer un CV", security={{"sanctum":{}}}, @OA\Response(response=200, description="Supprimé")) */
    public function destroy(Request $request, int $id)
    {
        $cv = CV::where('user_id', $request->user()->id)->find($id);
        if (! $cv) return ResponseController::response(false, 'CV non trouvé', null, 404);
        $cv->delete();

        return ResponseController::response(true, 'CV supprimé', null);
    }
}
