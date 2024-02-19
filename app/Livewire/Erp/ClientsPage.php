<?php

namespace App\Livewire\Erp;

use App\Exports\ClientsExport;
use App\Livewire\Forms\clientForm;
use App\Models\Client;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class ClientsPage extends Component
{
    use WithPagination;
    use WithFileUploads;
    public clientForm $clientForm;

    public $search;
    public $error_message;
    protected $paginationTheme = 'bootstrap';
    public $edit_avatar = false;

    public $breadcrumbs = array(
        array("name" => "Clients", "route" => "clients"),
    );

    public function render()
    {
        return view('livewire.erp.clients-page', [
            "breadcrumbs" => $this->breadcrumbs,
            'clients' => $this->clientSearch(),
        ]);
    }

    function clientSearch() {
        return Client::where('name', 'like', '%' . $this->search . '%')->orderBy('name')->paginate(16);
    }

    function gotoProjets($client_id)
    {
        return redirect()->route('projets', ['client_id' => $client_id]);
    }

    function store()
    {
        $this->clientForm->store();
        $this->dispatch('close-addClient');
    }

    public $selected;
    function edit($client_id)
    {
        $this->selected = Client::find($client_id);;
        $this->clientForm->set($client_id);
        $this->dispatch('open-editClient');
    }

    function update()
    {
        $this->clientForm->update($this->selected);
        $this->dispatch('close-editClient');
        $this->render();
    }
    function delete()
    {
        $client = Client::find($this->selected->id);

        if ($client->projets->count()) {
            $this->error_message = 'Ce client a des projets, il faut les supprimer avant';
        } else {
            $this->selected->delete();
            $this->dispatch('close-editClient');
        }
    }
    function download_xls()
    {
        return Excel::download(new ClientsExport, 'clients.xlsx');
    }
}
