<?php

namespace App\Livewire\Erp;

use App\Livewire\Forms\InvoiceProposalForm;
use App\Models\InvoiceProposal as ModelsInvoiceProposal;
use Livewire\Component;

class InvoiceProposal extends Component
{
    public $invoice_id;

    public function render()
    {
        return view('livewire.erp.invoice-proposal', [
            'proposals' => ModelsInvoiceProposal::where('invoice_id', $this->invoice_id)->get(),
        ]);
    }

    public InvoiceProposalForm $form;

    function store(){
        $this->form->invoice_id = $this->invoice_id;
        $this->form->store();
    }

    function edit($model_id){
        $this->form->set($model_id);
        $this->dispatch('open-editInvoiceProposal');
    }

    function update(){
        $this->form->update();
        $this->dispatch('close-editInvoiceProposal');
    }

    function delete($model_id){
        $this->form->delete($model_id);
    }

}
