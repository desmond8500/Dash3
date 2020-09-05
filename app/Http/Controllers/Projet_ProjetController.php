<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProjet_ProjetRequest;
use App\Http\Requests\UpdateProjet_ProjetRequest;
use App\Repositories\Projet_ProjetRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class Projet_ProjetController extends AppBaseController
{
    /** @var  Projet_ProjetRepository */
    private $projetProjetRepository;

    public function __construct(Projet_ProjetRepository $projetProjetRepo)
    {
        $this->projetProjetRepository = $projetProjetRepo;
    }

    /**
     * Display a listing of the Projet_Projet.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $projetProjets = $this->projetProjetRepository->paginate(10);

        return view('projet__projets.index')
            ->with('projetProjets', $projetProjets);
    }

    /**
     * Show the form for creating a new Projet_Projet.
     *
     * @return Response
     */
    public function create()
    {
        return view('projet__projets.create');
    }

    /**
     * Store a newly created Projet_Projet in storage.
     *
     * @param CreateProjet_ProjetRequest $request
     *
     * @return Response
     */
    public function store(CreateProjet_ProjetRequest $request)
    {
        $input = $request->all();

        $projetProjet = $this->projetProjetRepository->create($input);

        Flash::success('Projet  Projet saved successfully.');

        return redirect(route('projetProjets.index'));
    }

    /**
     * Display the specified Projet_Projet.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $projetProjet = $this->projetProjetRepository->find($id);

        if (empty($projetProjet)) {
            Flash::error('Projet  Projet not found');

            return redirect(route('projetProjets.index'));
        }

        return view('projet__projets.show')->with('projetProjet', $projetProjet);
    }

    /**
     * Show the form for editing the specified Projet_Projet.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $projetProjet = $this->projetProjetRepository->find($id);

        if (empty($projetProjet)) {
            Flash::error('Projet  Projet not found');

            return redirect(route('projetProjets.index'));
        }

        return view('projet__projets.edit')->with('projetProjet', $projetProjet);
    }

    /**
     * Update the specified Projet_Projet in storage.
     *
     * @param int $id
     * @param UpdateProjet_ProjetRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateProjet_ProjetRequest $request)
    {
        $projetProjet = $this->projetProjetRepository->find($id);

        if (empty($projetProjet)) {
            Flash::error('Projet  Projet not found');

            return redirect(route('projetProjets.index'));
        }

        $projetProjet = $this->projetProjetRepository->update($request->all(), $id);

        Flash::success('Projet  Projet updated successfully.');

        return redirect(route('projetProjets.index'));
    }

    /**
     * Remove the specified Projet_Projet from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $projetProjet = $this->projetProjetRepository->find($id);

        if (empty($projetProjet)) {
            Flash::error('Projet  Projet not found');

            return redirect(route('projetProjets.index'));
        }

        $this->projetProjetRepository->delete($id);

        Flash::success('Projet  Projet deleted successfully.');

        return redirect(route('projetProjets.index'));
    }
}
