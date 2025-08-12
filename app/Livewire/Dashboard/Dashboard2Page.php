<?php

namespace App\Livewire\Dashboard;

use App\Http\Controllers\InvoiceController;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Projet;
use Livewire\Component;

class Dashboard2Page extends Component
{
    public $search = null;
    public $tabs;

    public $selected_tab;

    function mount(){
        $this->tabs = [
            (object) array('id'=> 0, 'name'=> 'Clients' ),
            (object) array('id'=> 1, 'name'=> 'Projets' ),
            (object) array('id'=> 2, 'name'=> 'Devis' ),
        ];
        $this->selected_tab = $this->tabs[0];
    }

    public function render()
    {
        return view('livewire.dashboard.dashboard2-page',[
            'clients' => $this->search ?  Client::search($this->search)->get() : [] ,
            'projets' => $this->search ? Projet::search($this->search, 'name')->get() : [],
            'invoices' => $this->search ? Invoice::where('reference', 'like', '%' . $this->search . '%')->orWhere('description', 'like', '%' . $this->search . '%') ->get() : [],
            'statuses' => InvoiceController::statut(),
        ]);
    }

    function select_tab($tab){
        $this->selected_tab = $this->tabs[$tab];
    }

    function get_clients(){

    }
}
