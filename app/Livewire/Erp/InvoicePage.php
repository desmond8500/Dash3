<?php

namespace App\Livewire\Erp;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class InvoicePage extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';
    public $search ='';
    public $breadcrumbs;
    public $devis, $devis_id;

    public function mount(){
        $this->breadcrumbs = array(
            array('name' => 'Clients', 'route' => route('clients')),
            // array('name' => $this->devis->projet->client->name, 'route' => route('clients', ['client_id' => $this->devis->projet->client->id])),
            // array('name' => $this->devis->projet->name, 'route' => route('projets', ['projet_id' => $this->devis->projet->id])),
            // array('name' => $this->devis->name, 'route' => route('devis', ['devis_id' => $this->devis->id])),
        );
    }

    function ProjetSearch() {
        // return ::where('client_id', $this->client_id)->where('name', 'like', '%' . $this->search . '%')->paginate(10);
    }

    public function render()
    {
        return view('livewire.erp.invoice-page');
    }
}
