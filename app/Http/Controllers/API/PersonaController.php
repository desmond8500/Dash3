<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePersonaRequest;
use App\Http\Requests\UpdatePersonaRequest;
use App\Http\Resources\Api\PersonaResource;
use App\Models\Persona;
use Illuminate\Http\Request;

class PersonaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PersonaResource::collection(Persona::latest()->paginate(20));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePersonaRequest $request)
    {
        $data = $request->validated();

        $persona = Persona::create($data);

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');

            $path = $file->store(
                "medias/personas/{$persona->id}/avatar",
                'public'
            );

            $persona->update([
                'avatar' => "storage/$path"
            ]);
        }

        return new PersonaResource($persona);
    }

    /**
     * Display the specified resource.
     */
    public function show(Persona $persona)
    {
        return new PersonaResource($persona);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePersonaRequest $request, Persona $persona)
    {

        $data = $request->validated();

        $persona->update($request->validated());

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');

            $path = $file->store(
                "medias/personas/{$persona->id}/avatar",
                'public'
            );

            $persona->update([
                'avatar' => "storage/$path"
            ]);
        }

        return new PersonaResource($persona);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Persona $persona)
    {
        $persona->delete();

        return response()->json([
            'message' => 'Persona supprimée.'
        ]);
    }
}
