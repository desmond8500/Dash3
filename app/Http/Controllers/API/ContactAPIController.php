<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseController;
use App\Models\Contact;
use Illuminate\Http\Request;

/** Contacts d'un client ou d'un projet */
class ContactAPIController extends Controller
{
    private function rules(bool $create): array
    {
        $s = $create ? [] : ['sometimes'];

        return [
            'client_id' => [...$s, 'nullable', 'integer', 'exists:clients,id'],
            'projet_id' => [...$s, 'nullable', 'integer', 'exists:projets,id'],
            'firstname' => [...$s, 'required', 'string', 'max:255'],
            'lastname' => [...$s, 'nullable', 'string', 'max:255'],
            'fonction' => [...$s, 'nullable', 'string', 'max:255'],
            'societe' => [...$s, 'nullable', 'string', 'max:255'],
            'phone' => [...$s, 'nullable', 'string', 'max:50'],
            'email' => [...$s, 'nullable', 'email', 'max:255'],
        ];
    }

    private function present(Contact $c): array
    {
        return [
            'id' => $c->id,
            'client_id' => $c->client_id,
            'projet_id' => $c->projet_id,
            'firstname' => $c->firstname,
            'lastname' => $c->lastname,
            'fonction' => $c->fonction,
            'societe' => $c->societe,
            'phone' => $c->phone,
            'email' => $c->email,
            'avatar' => $c->avatar ? url($c->avatar) : null,
        ];
    }

    /** @OA\Get(path="/api/v1/contacts", tags={"Contacts"}, summary="Contacts (?client_id= ou ?projet_id=)", security={{"sanctum":{}}}, @OA\Response(response=200, description="Success")) */
    public function index(Request $request)
    {
        $contacts = Contact::query()
            ->when($request->filled('client_id'), fn ($q) => $q->where('client_id', $request->client_id))
            ->when($request->filled('projet_id'), fn ($q) => $q->where('projet_id', $request->projet_id))
            ->orderBy('firstname')
            ->get()
            ->map(fn ($c) => $this->present($c));

        return ResponseController::response(true, 'Contacts récupérés', $contacts);
    }

    /** @OA\Post(path="/api/v1/contacts", tags={"Contacts"}, summary="Ajouter un contact (client_id ou projet_id)", security={{"sanctum":{}}}, @OA\Response(response=201, description="Créé")) */
    public function store(Request $request)
    {
        $data = $request->validate($this->rules(true));
        if (empty($data['client_id']) && empty($data['projet_id'])) {
            return response()->json(['success' => false, 'message' => 'Indiquez un client ou un projet', 'error' => null, 'meta' => null], 422);
        }
        $data['firstname'] = ucfirst($data['firstname']);
        $contact = Contact::create($data);

        return response()->json(['success' => true, 'message' => 'Contact ajouté', 'data' => $this->present($contact), 'meta' => null], 201);
    }

    /** @OA\Put(path="/api/v1/contacts/{id}", tags={"Contacts"}, summary="Modifier un contact", security={{"sanctum":{}}}, @OA\Response(response=200, description="Modifié")) */
    public function update(Request $request, int $id)
    {
        $contact = Contact::find($id);
        if (! $contact) {
            return response()->json(['success' => false, 'message' => 'Contact introuvable', 'error' => null, 'meta' => null], 404);
        }
        $contact->update($request->validate($this->rules(false)));

        return ResponseController::response(true, 'Contact modifié', $this->present($contact));
    }

    /** @OA\Delete(path="/api/v1/contacts/{id}", tags={"Contacts"}, summary="Supprimer un contact", security={{"sanctum":{}}}, @OA\Response(response=200, description="Supprimé")) */
    public function destroy(int $id)
    {
        $contact = Contact::find($id);
        if (! $contact) {
            return response()->json(['success' => false, 'message' => 'Contact introuvable', 'error' => null, 'meta' => null], 404);
        }
        $contact->delete();

        return ResponseController::response(true, 'Contact supprimé', null);
    }
}
