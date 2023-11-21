<?php

namespace App\Livewire\Erp;

use App\Livewire\Forms\clientForm;
use App\Models\Client;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Clients extends Component
{
    use WithPagination;
    use WithFileUploads;
    public clientForm $clientForm;

    public $search;
    public $error_message;

    public $breadcrumbs = array(
        array("name" => "Clients", "route" => "clients"),
    );
    public function render()
    {
        return view('livewire.erp.clients',[
            "breadcrumbs" => $this->breadcrumbs,
            // 'clients' => Client::search($this->search)->paginate(10),
            'clients' => $this->clientSearch(),
        ]);
    }

    function clientSearch() {
        return Client::where('name', 'like', '%' . $this->search . '%')->orderBy('name')->paginate(10);
    }

    function gotoProjets($client_id){
        return redirect()->route('projets',['client_id'=> $client_id]);
    }

    function store() {
        $this->clientForm->store();
        $this->dispatch('close-addClient');
    }

    public $selected;
    function edit($client_id) {
        $this->selected = Client::find($client_id);;
        $this->clientForm->set($this->selected);
        $this->dispatch('open-editClient');
    }

    function update() {
        $this->clientForm->update($this->selected);
        $this->dispatch('close-editClient');
        $this->render();
    }
    function delete() {
        $client = Client::find($this->selected->id);

        if ($client->projets->count()) {
            $this->error_message = 'Ce client a des projets, il faut les supprimer avant';
        }else{
            $this->selected->delete();
            $this->dispatch('close-editClient');
        }
    }
}
