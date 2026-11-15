<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseController;
use App\Http\Resources\ClientResource;
use App\Http\Controllers\ImageController;
use App\Models\Client;
use App\Models\Contact;
use App\Models\Projet;
use App\Models\Task;
use Illuminate\Http\Request;

class ClientAPIController extends Controller
{

    /**
        *@OA\Get(
        *      path="/api/v1/clients",
        *      tags={"Clients"},
        *      summary="Liste des clients",
        *      @OA\Parameter(
        *          name="search",
        *          in="query",
        *          required=false,
        *          description="Termes de recherche",
        *          @OA\Schema(
        *              type="string"
        *          )
        *      ),
        *      @OA\Response(
        *          response=200,
        *          description="Clients récupérés avec succès",
        *       ),
        *     )
    */

    function index(Request $request){
        if($request->perPage){
            $perPage = 1000;
        }else{
            $perPage = min($request->get('per_page', 9), 100);
        }

        $clients = Client::search($request->search)
            ->withCount(['projets', 'tasks'])
            ->addSelect(['contacts_count' => Contact::selectRaw('count(*)')->whereColumn('contacts.client_id', 'clients.id')])
            ->when($request->boolean('favorites'), fn ($q) => $q->where('favorite', true))
            ->orderBy('name', 'asc')
            ->paginate($perPage);
        $clients = ClientResource::collection($clients);


        return ResponseController::response(true, 'Les  clients  ont été récupérés avec succès', $clients, [
            'current_page' => $clients->currentPage(),
            'last_page' => $clients->lastPage(),
            'per_page' => $clients->perPage(),
            'total' => $clients->total(),
        ]);
    }

    /**
        *@OA\Get(
        *      path="/api/v1/clients/{id}",
        *      tags={"Clients"},
        *      summary="Détails d'un client",
        *      @OA\Parameter(
        *          name="id",
        *          in="path",
        *          required=true,
        *          description="ID du client",
        *          @OA\Schema(
        *              type="integer"
        *          )
        *      ),
        *      @OA\Response(
        *          response=200,
        *          description="Client récupéré avec succès",
        *       ),
        *      @OA\Response(
        *          response=404,
        *          description="Client non trouvé",
        *       ),
        *     )
    */

    function show(int|string $id){
        $client = Client::withCount(['projets', 'tasks'])
            ->addSelect(['contacts_count' => Contact::selectRaw('count(*)')->whereColumn('contacts.client_id', 'clients.id')])
            ->find($id);
        if ($client) {
            return ResponseController::response(true, 'Le client a été récupéré avec succès', new ClientResource($client));
        } else {
            return ResponseController::response(false, 'Client non trouvé', null, 404);
        }
    }

    /**
        *@OA\Post(
        *      path="/api/v1/clients",
        *      tags={"Clients",},
        *      summary="Ajouter un client",
        *      @OA\RequestBody(
        *          required=true,
        *          @OA\JsonContent(
        *              required={"name",},
        *              @OA\Property(property="name", type="string", example="Client Name"),
        *              @OA\Property(property="description", type="string", example=""),
        *              @OA\Property(property="avatar", type="string", example=""),
        *              @OA\Property(property="status", type="integer", example="1"),
        *              @OA\Property(property="type", type="1", example="1"),
        *              @OA\Property(property="favorite", type="string", example="1"),
        *          )
        *      ),
        *      @OA\Response(
        *          response=201,
        *          description="Client créé avec succès",
        *       ),
        *      @OA\Response(
        *          response=400,
        *          description="Erreur lors de la création du client",
        *       ),
        *     )
    */
    function store(Request $request){
        $client = new Client();
        $client->name = $request->name;
        $client->description = $request->description;
        $client->address = $request->address;
        // $client->avatar = $request->avatar;
        $client->status = $request->status;
        $client->type = $request->type;
        $client->favorite = $request->favorite;

        if ($client->save()) {
            return ResponseController::response(true, 'Client créé avec succès', null, 201);
        } else {
            return ResponseController::response(false, 'Erreur lors de la création du client', null, 400);
        }
    }

    /**
        *@OA\Put(
        *      path="/api/v1/clients/{id}",
        *      tags={"Clients",},
        *      summary="Mettre à jour un client",
        *      @OA\Parameter(
        *          name="id",
        *          in="path",
        *          required=true,
        *          description="ID du client",
        *          @OA\Schema(
        *              type="integer"
        *          )
        *      ),
        *      @OA\RequestBody(
        *          required=true,
        *          @OA\JsonContent(
        *              required={"name",},
        *              @OA\Property(property="name", type="string", example="Client Name"),
        *              @OA\Property(property="description", type="string", example=""),
        *              @OA\Property(property="avatar", type="string", example=""),
        *              @OA\Property(property="status", type="integer", example="1"),
        *              @OA\Property(property="type", type="1", example="1"),
        *              @OA\Property(property="favorite", type="string", example="1"),
        *          )
        *      ),
        *      @OA\Response(
        *          response=200,
        *          description="Client mis à jour avec succès",
        *       ),
        *      @OA\Response(
        *          response=404,
        *          description="Client non trouvé",
        *       ),
        *      @OA\Response(
        *          response=400,
        *          description="Erreur lors de la mise à jour du client",
        *       ),
        *     )
    */
    function update(Request $request, int $id){
        $client = Client::find($id);
        if (! $client) {
            return response()->json(['success' => false, 'message' => 'Client non trouvé', 'error' => null, 'meta' => null], 404);
        }

        // Seuls les champs envoyés sont modifiés (avant, un champ absent était remis à null)
        $data = $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['sometimes', 'nullable', 'string'],
            'address' => ['sometimes', 'nullable', 'string', 'max:255'],
            'status' => ['sometimes', 'nullable', 'string', 'max:255'],
            'type' => ['sometimes', 'nullable', 'string', 'max:255'],
            'favorite' => ['sometimes', 'boolean'],
        ]);
        $client->update($data);

        return ResponseController::response(true, 'Client mis à jour avec succès', new ClientResource($client->fresh()));
    }

    /**
     * @OA\Post(
     *      path="/api/v1/clients/{id}/favorite",
     *      tags={"Clients"},
     *      summary="Ajouter ou retirer un client des favoris",
     *      security={{"sanctum":{}}},
     *      @OA\Response(response=200, description="Favori mis à jour")
     * )
     */
    function toggleFavorite(int $id){
        $client = Client::find($id);
        if (! $client) {
            return response()->json(['success' => false, 'message' => 'Client non trouvé', 'error' => null, 'meta' => null], 404);
        }
        $client->favorite = ! $client->favorite;
        $client->save();

        return ResponseController::response(true, $client->favorite ? 'Client ajouté aux favoris' : 'Client retiré des favoris', ['favorite' => (bool) $client->favorite]);
    }

    /**
     * @OA\Post(
     *      path="/api/v1/clients/{id}/avatar",
     *      tags={"Clients"},
     *      summary="Remplacer le logo / l'avatar d'un client (multipart, champ image)",
     *      security={{"sanctum":{}}},
     *      @OA\Response(response=200, description="Avatar mis à jour")
     * )
     */
    function updateAvatar(Request $request, int $id){
        $client = Client::find($id);
        if (! $client) {
            return response()->json(['success' => false, 'message' => 'Client non trouvé', 'error' => null, 'meta' => null], 404);
        }
        $request->validate(['image' => ['required', 'image', 'max:4096']]);

        // Même dossier que le formulaire web (clientForm::storeAvatar)
        $client->avatar = ImageController::update_logo("erp/clients/$client->id/avatar", $request->file('image'));
        $client->save();

        return ResponseController::response(true, 'Avatar mis à jour', new ClientResource($client));
    }

    /**
        *@OA\Delete(
        *      path="/api/v1/clients/{id}",
        *      tags={"Clients",},
        *      summary="Supprimer un client",
        *      @OA\Parameter(
        *          name="id",
        *          in="path",
        *          required=true,
        *          description="ID du client",
        *          @OA\Schema(
        *              type="integer"
        *          )
        *      ),
        *      @OA\Response(
        *          response=200,
        *          description="Client supprimé avec succès",
        *       ),
        *      @OA\Response(
        *          response=404,
        *          description="Client non trouvé",
        *       ),
        *      @OA\Response(
        *          response=400,
        *          description="Erreur lors de la suppression du client",
        *       ),
        *     )
    */

    function destroy(int $id){
        $client = Client::findorFail($id);
        if ($client) {
            if ($client->delete()) {
                return ResponseController::response(true, 'Client supprimé avec succès', null, 200);
            } else {
                return ResponseController::response(false, 'Erreur lors de la suppression du client', null, 400);
            }
        } else {
            return ResponseController::response(false, 'Client non trouvé', null, 404);
        }
    }

    /**
     *@OA\Get(
     *      path="/api/v1/clients_projets/{client_id}",
     *      tags={"Clients"},
     *      summary="Liste des projets d'un client",
     *      @OA\Parameter(
     *          name="client_id",
     *          in="path",
     *          required=true,
     *          description="ID du client",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Projets récupérés avec succès",
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Client non trouvé",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Erreur lors de la récupération des projets",
     *       ),
     *     )
     */

    function getProjets(int|string $client_id){
        $client = Client::findorFail($client_id);
        if ($client) {
            // $projets = $client->projets;
            $projets = Projet::where('client_id', '=', $client_id, true)->orderBy('name', 'asc')->get();


            return ResponseController::response(true, 'Projets récupérés avec succès', $projets, 200);
        } else {
            return ResponseController::response(false, 'Client non trouvé', null, 404);
        }
    }

    /**
     *@OA\Get(
     *      path="/api/v1/clients/tasks/{client_id}",
     *      tags={"Clients","Taches"},
     *      summary="Liste des tâches d'un client",
     *      @OA\Parameter(
     *          name="client_id",
     *          in="path",
     *          required=true,
     *          description="ID du client",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Tâches récupérées avec succès",
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Client non trouvé",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Erreur lors de la récupération des tâches",
     *       ),
     *     )
     */
    function getTasksByClient(int $client_id){
        $client = Client::findorFail($client_id);
        if ($client) {
            // Tâches rattachées au client ou à l'un de ses projets
            // (avant : where('client_id', '==', …) ne renvoyait jamais rien)
            $tasks = Task::where('client_id', $client_id)
                ->orWhereIn('projet_id', $client->projets()->select('id'))
                ->with('projet:id,name')
                ->orderBy('name', 'asc')
                ->get();
            return ResponseController::response(true, 'Tâches récupérées avec succès', $tasks, 200);
        } else {
            return ResponseController::response(false, 'Client non trouvé', null, 404);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/v1/clients/{id}/contacts",
     *      tags={"Clients"},
     *      summary="Contacts d'un client (comme l'onglet Contacts de la page Projets)",
     *      security={{"sanctum":{}}},
     *      @OA\Response(response=200, description="Success")
     * )
     */
    function getContacts(int $id)
    {
        if (! Client::whereKey($id)->exists()) {
            return response()->json(['success' => false, 'message' => 'Client non trouvé', 'error' => null, 'meta' => null], 404);
        }
        $contacts = Contact::where('client_id', $id)
            ->orderBy('firstname')
            ->get()
            ->map(fn ($c) => [
                'id' => $c->id,
                'firstname' => $c->firstname,
                'lastname' => $c->lastname,
                'fonction' => $c->fonction,
                'societe' => $c->societe,
                'phone' => $c->phone,
                'email' => $c->email,
                'projet_id' => $c->projet_id,
                'avatar' => $c->avatar ? url($c->avatar) : null,
            ]);

        return ResponseController::response(true, 'Contacts récupérés', $contacts);
    }
}
