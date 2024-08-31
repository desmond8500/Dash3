<?php

namespace App\Livewire\Erp;

use Livewire\Component;
use Livewire\WithPagination;

class InvoiceModelPage extends Component
{
    use WithPagination;
    public $breadcrumbs;
    protected $paginationTheme = 'bootstrap';


    public function mount(){
        $this->breadcrumbs = array(
            array('name' => 'Modèles de devis', 'route' => route('invoice_model')),
        );
    }

    public function render()
    {
        return view('livewire.erp.invoice-model-page');
    }
}
