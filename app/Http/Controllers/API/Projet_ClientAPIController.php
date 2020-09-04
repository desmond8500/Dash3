<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateProjet_ClientAPIRequest;
use App\Http\Requests\API\UpdateProjet_ClientAPIRequest;
use App\Models\Projet_Client;
use App\Repositories\Projet_ClientRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class Projet_ClientController
 * @package App\Http\Controllers\API
 */

class Projet_ClientAPIController extends AppBaseController
{
    /** @var  Projet_ClientRepository */
    private $projetClientRepository;

    public function __construct(Projet_ClientRepository $projetClientRepo)
    {
        $this->projetClientRepository = $projetClientRepo;
    }

    /**
     * Display a listing of the Projet_Client.
     * GET|HEAD /projetClients
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $projetClients = $this->projetClientRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($projetClients->toArray(), 'Projet  Clients retrieved successfully');

    }

    /**
     * Store a newly created Projet_Client in storage.
     * POST /projetClients
     *
     * @param CreateProjet_ClientAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateProjet_ClientAPIRequest $request)
    {
        $input = $request->all();

        $projetClient = $this->projetClientRepository->create($input);

        return $this->sendResponse($projetClient->toArray(), 'Projet  Client saved successfully');
    }

    /**
     * Display the specified Projet_Client.
     * GET|HEAD /projetClients/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Projet_Client $projetClient */
        $projetClient = $this->projetClientRepository->find($id);

        if (empty($projetClient)) {
            return $this->sendError('Projet  Client not found');
        }

        return $this->sendResponse($projetClient->toArray(), 'Projet  Client retrieved successfully');
    }

    /**
     * Update the specified Projet_Client in storage.
     * PUT/PATCH /projetClients/{id}
     *
     * @param int $id
     * @param UpdateProjet_ClientAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateProjet_ClientAPIRequest $request)
    {
        $input = $request->all();

        /** @var Projet_Client $projetClient */
        $projetClient = $this->projetClientRepository->find($id);

        if (empty($projetClient)) {
            return $this->sendError('Projet  Client not found');
        }

        $projetClient = $this->projetClientRepository->update($input, $id);

        return $this->sendResponse($projetClient->toArray(), 'Projet_Client updated successfully');
    }

    /**
     * Remove the specified Projet_Client from storage.
     * DELETE /projetClients/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Projet_Client $projetClient */
        $projetClient = $this->projetClientRepository->find($id);

        if (empty($projetClient)) {
            return $this->sendError('Projet  Client not found');
        }

        $projetClient->delete();

        return $this->sendSuccess('Projet  Client deleted successfully');
    }
}
