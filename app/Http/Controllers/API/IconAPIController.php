<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ResponseController;
use App\Models\Icon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/** Table d'icônes : chaque icône est liée aux articles par un tag et matérialise les équipements sur les plans */
class IconAPIController extends Controller
{
    private function rules(bool $create): array
    {
        $s = $create ? [] : ['sometimes'];

        return [
            'name' => [...$s, 'required', 'string', 'max:255'],
            'tag' => [...$s, 'nullable', 'string', 'max:255'],
            'tabler' => [...$s, 'nullable', 'string', 'max:60', 'regex:/^ti-[a-z0-9-]+$/'],
            'color' => [...$s, 'nullable', 'string', 'max:20', 'regex:/^#?[0-9a-zA-Z]+$/'],
        ];
    }

    /** @OA\Get(path="/api/v1/icons", tags={"Icônes"}, summary="Table d'icônes", security={{"sanctum":{}}}, @OA\Response(response=200, description="Success")) */
    public function index()
    {
        return ResponseController::response(true, 'Icônes récupérées', Icon::orderBy('name')->get());
    }

    /** @OA\Post(path="/api/v1/icons", tags={"Icônes"}, summary="Ajouter une icône (multipart possible : image)", security={{"sanctum":{}}}, @OA\Response(response=201, description="Créée")) */
    public function store(Request $request)
    {
        $data = $request->validate($this->rules(true) + ['image' => ['nullable', 'image', 'max:2048']]);
        unset($data['image']);
        $icon = Icon::create($data);
        if ($request->hasFile('image')) {
            $icon->update(['image' => ImageController::update_logo("stock/icons/{$icon->id}", $request->file('image'))]);
        }

        return response()->json(['success' => true, 'message' => 'Icône ajoutée', 'data' => $icon->fresh(), 'meta' => null], 201);
    }

    /** @OA\Put(path="/api/v1/icons/{id}", tags={"Icônes"}, summary="Modifier une icône", security={{"sanctum":{}}}, @OA\Response(response=200, description="Modifiée")) */
    public function update(Request $request, int $id)
    {
        $icon = Icon::find($id);
        if (! $icon) return response()->json(['success' => false, 'message' => 'Icône introuvable', 'error' => null, 'meta' => null], 404);
        $icon->update($request->validate($this->rules(false)));

        return ResponseController::response(true, 'Icône modifiée', $icon);
    }

    /** @OA\Post(path="/api/v1/icons/{id}/image", tags={"Icônes"}, summary="Changer l'image de l'icône", security={{"sanctum":{}}}, @OA\Response(response=200, description="Modifiée")) */
    public function updateImage(Request $request, int $id)
    {
        $icon = Icon::find($id);
        if (! $icon) return response()->json(['success' => false, 'message' => 'Icône introuvable', 'error' => null, 'meta' => null], 404);
        $request->validate(['image' => ['required', 'image', 'max:2048']]);
        $icon->update(['image' => ImageController::update_logo("stock/icons/{$icon->id}", $request->file('image'))]);

        return ResponseController::response(true, 'Image modifiée', $icon);
    }

    /** @OA\Delete(path="/api/v1/icons/{id}", tags={"Icônes"}, summary="Supprimer une icône", security={{"sanctum":{}}}, @OA\Response(response=200, description="Supprimée")) */
    public function destroy(int $id)
    {
        $icon = Icon::find($id);
        if (! $icon) return response()->json(['success' => false, 'message' => 'Icône introuvable', 'error' => null, 'meta' => null], 404);
        Storage::disk('public')->deleteDirectory("stock/icons/{$icon->id}");
        $icon->delete();

        return ResponseController::response(true, 'Icône supprimée', null);
    }
}
