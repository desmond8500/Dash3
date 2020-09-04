<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProjet_ClientRequest;
use App\Http\Requests\UpdateProjet_ClientRequest;
use App\Repositories\Projet_ClientRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class Projet_ClientController extends AppBaseController
{
    /** @var  Projet_ClientRepository */
    private $projetClientRepository;

    public function __construct(Projet_ClientRepository $projetClientRepo)
    {
        $this->projetClientRepository = $projetClientRepo;
    }

    /**
     * Display a listing of the Projet_Client.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $projetClients = $this->projetClientRepository->paginate(10);

        return view('projet__clients.index')
            ->with('projetClients', $projetClients);
    }

    /**
     * Show the form for creating a new Projet_Client.
     *
     * @return Response
     */
    public function create()
    {
        return view('projet__clients.create');
    }

    /**
     * Store a newly created Projet_Client in storage.
     *
     * @param CreateProjet_ClientRequest $request
     *
     * @return Response
     */
    public function store(CreateProjet_ClientRequest $request)
    {
        $input = $request->all();

        $projetClient = $this->projetClientRepository->create($input);

        Flash::success('Projet  Client saved successfully.');

        return redirect(route('projetClients.index'));
    }

    /**
     * Display the specified Projet_Client.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $projetClient = $this->projetClientRepository->find($id);

        if (empty($projetClient)) {
            Flash::error('Projet  Client not found');

            return redirect(route('projetClients.index'));
        }

        return view('projet__clients.show')->with('projetClient', $projetClient);
    }

    /**
     * Show the form for editing the specified Projet_Client.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $projetClient = $this->projetClientRepository->find($id);

        if (empty($projetClient)) {
            Flash::error('Projet  Client not found');

            return redirect(route('projetClients.index'));
        }

        return view('projet__clients.edit')->with('projetClient', $projetClient);
    }

    /**
     * Update the specified Projet_Client in storage.
     *
     * @param int $id
     * @param UpdateProjet_ClientRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateProjet_ClientRequest $request)
    {
        $projetClient = $this->projetClientRepository->find($id);

        if (empty($projetClient)) {
            Flash::error('Projet  Client not found');

            return redirect(route('projetClients.index'));
        }

        $projetClient = $this->projetClientRepository->update($request->all(), $id);

        Flash::success('Projet  Client updated successfully.');

        return redirect(route('projetClients.index'));
    }

    /**
     * Remove the specified Projet_Client from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $projetClient = $this->projetClientRepository->find($id);

        if (empty($projetClient)) {
            Flash::error('Projet  Client not found');

            return redirect(route('projetClients.index'));
        }

        $this->projetClientRepository->delete($id);

        Flash::success('Projet  Client deleted successfully.');

        return redirect(route('projetClients.index'));
    }
}
