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
        return Client::where('name', 'like', '%' . $this->search . '%')->paginate(10);
    }

    function gotoProjets($client_id){
        return redirect()->route('projets',['client_id'=> $client_id]);
    }

    function store() {
        $this->clientForm->store();
        $this->dispatch('close-addClient');
    }

    public $selected;
    function edit($client) {
        $this->selected = $client;
        $this->clientForm->set($this->selected);
        $this->dispatch('open-editClient');
    }

    function update() {
        $this->clientForm->update($this->selected);
        $this->dispatch('close-editClient');
        $this->render();
    }
    function delete() {
        $this->clientForm->delete($this->selected['id']);
        $this->dispatch('close-editClient');
        $this->render();
    }
}
