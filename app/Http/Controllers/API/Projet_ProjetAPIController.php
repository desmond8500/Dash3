<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateProjet_ProjetAPIRequest;
use App\Http\Requests\API\UpdateProjet_ProjetAPIRequest;
use App\Models\Projet_Projet;
use App\Repositories\Projet_ProjetRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class Projet_ProjetController
 * @package App\Http\Controllers\API
 */

class Projet_ProjetAPIController extends AppBaseController
{
    /** @var  Projet_ProjetRepository */
    private $projetProjetRepository;

    public function __construct(Projet_ProjetRepository $projetProjetRepo)
    {
        $this->projetProjetRepository = $projetProjetRepo;
    }

    /**
     * Display a listing of the Projet_Projet.
     * GET|HEAD /projetProjets
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $projetProjets = $this->projetProjetRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($projetProjets->toArray(), 'Projet  Projets retrieved successfully');
    }

    /**
     * Store a newly created Projet_Projet in storage.
     * POST /projetProjets
     *
     * @param CreateProjet_ProjetAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateProjet_ProjetAPIRequest $request)
    {
        $input = $request->all();

        $projetProjet = $this->projetProjetRepository->create($input);

        return $this->sendResponse($projetProjet->toArray(), 'Projet  Projet saved successfully');
    }

    /**
     * Display the specified Projet_Projet.
     * GET|HEAD /projetProjets/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Projet_Projet $projetProjet */
        $projetProjet = $this->projetProjetRepository->find($id);

        if (empty($projetProjet)) {
            return $this->sendError('Projet  Projet not found');
        }

        return $this->sendResponse($projetProjet->toArray(), 'Projet  Projet retrieved successfully');
    }

    /**
     * Update the specified Projet_Projet in storage.
     * PUT/PATCH /projetProjets/{id}
     *
     * @param int $id
     * @param UpdateProjet_ProjetAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateProjet_ProjetAPIRequest $request)
    {
        $input = $request->all();

        /** @var Projet_Projet $projetProjet */
        $projetProjet = $this->projetProjetRepository->find($id);

        if (empty($projetProjet)) {
            return $this->sendError('Projet  Projet not found');
        }

        $projetProjet = $this->projetProjetRepository->update($input, $id);

        return $this->sendResponse($projetProjet->toArray(), 'Projet_Projet updated successfully');
    }

    /**
     * Remove the specified Projet_Projet from storage.
     * DELETE /projetProjets/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Projet_Projet $projetProjet */
        $projetProjet = $this->projetProjetRepository->find($id);

        if (empty($projetProjet)) {
            return $this->sendError('Projet  Projet not found');
        }

        $projetProjet->delete();

        return $this->sendSuccess('Projet  Projet deleted successfully');
    }
}
