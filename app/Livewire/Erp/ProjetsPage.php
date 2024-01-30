<?php

namespace App\Livewire\Erp;

use App\Livewire\Forms\projetForm;
use App\Models\Client;
use App\Models\Projet;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ProjetsPage extends Component
{
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $breadcrumbs;
    public $client_id, $selected;
    public projetForm $projetForm;

    public function mount($client_id)
    {
        $this->client_id = $client_id;
        $this->projetForm->client_id = $client_id;
        $client = Client::find($client_id);

        $this->breadcrumbs = array(
            array('name' => 'Clients', 'route' => route('clients')),
            array('name' => $client->name, 'route' => route('projets',['client_id'=>$client->id])),
        );
    }

    public function render()
    {
        return view('livewire.erp.projets-page', [
            'projets' => $this->ProjetSearch(),
        ]);
    }

    function ProjetSearch() {
        return Projet::where('client_id', $this->client_id)->where('name', 'like', '%' . $this->search . '%')->paginate(20);
    }

    function store() {
        $this->projetForm->store();
        $this->dispatch('close-addProjet');
        $this->reset('projetForm.name', 'projetForm.description');
    }

    function edit($projet_id) {
        $this->selected = Projet::find($projet_id);

        $this->projetForm->name = $this->selected->name;
        $this->projetForm->description = $this->selected->description;
        $this->projetForm->start_date = $this->selected->start_date;
        $this->projetForm->end_date = $this->selected->end_date;

        $this->dispatch('open-editProjet');
    }

    function update() {
        $this->projetForm->update($this->selected->id);
        $this->dispatch('close-editProjet');
    }

    function delete() {
        $this->selected->delete();
        $this->dispatch('close-editProjet');
    }
}
