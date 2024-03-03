<?php

namespace App\Livewire\Erp;

use App\Livewire\Forms\InvoiceAcompteForm;
use App\Models\Invoice;
use Livewire\Component;
use Livewire\WithPagination;

class InvoiceAcompte extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $search ='';

    public function mount($invoice_id){
        $this->invoice = Invoice::find($invoice_id);
    }

    function getSearch() {
        return $this->invoice->acomptes;
        // return ModelsInvoiceAcompte::where('invoice_id', $this->invoice_id)->where('name', 'like', '%' . $this->search . '%')->paginate(10);
    }

    public function render()
    {
        return view('livewire.erp.invoice-acompte',[
            'acomptes' => $this->getSearch(),
        ]);
    }

public $invoice;
public InvoiceAcompteForm $acompte_form;

function store(){
    $this->acompte_form->store($this->invoice->id);
    $this->dispatch('close-add-invoiceAcompte');
}

function edit($id){
    $this->acompte_form->set($id);
    $this->dispatch('open-edit-invoiceAcompte');
}

function update(){
    $this->acompte_form->update();
    $this->dispatch('close-edit-invoiceAcompte');
}

function delete($id){
    $this->acompte_form->delete($id);
}
}
