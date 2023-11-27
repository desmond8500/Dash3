<?php

namespace App\Livewire\Erp;

use App\Models\Invoice;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class InvoicesList extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $search ='';


    function getInvoices() {
        return Invoice::where('client_id', $this->client_id)->where('name', 'like', '%' . $this->search . '%')->paginate(12);
    }

    public $projet_id;
    function mount($projet_id){
        $this->projet_id = $projet_id;
    }

    public function render()
    {
        return view('livewire.erp.invoices-list',[
            'invoices' => $this->getInvoices(),
        ]);
    }



}
