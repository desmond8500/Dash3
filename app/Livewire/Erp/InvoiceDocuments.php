<?php

namespace App\Livewire\Erp;

use App\Livewire\Forms\invoiceDocument;
use App\Models\Invoice;
use App\Models\InvoiceDocument as ModelsInvoiceDocument;
use Livewire\Component;
use Livewire\WithFileUploads;

class InvoiceDocuments extends Component
{
    use WithFileUploads;

    public $invoice_id;

    function mount($invoice_id){
        $this->invoice_id = $invoice_id;
    }
    public function render()
    {
        return view('livewire.erp.invoice-documents',[
            'documents' => ModelsInvoiceDocument::where('invoice_id', $this->invoice_id)->get()
        ]);
    }

    public invoiceDocument $document_form;

    function store(){
        $this->document_form->invoice_id = $this->invoice_id;
        $this->document_form->store();
        $this->dispatch('get-documents');
        $this->dispatch('close-add-invoiceDocument');
    }

    function edit($id){
        // $this->dispatch('close-add-invoiceDocument');
        $this->document_form->set($id);
    }

    function update($id){
        $this->document_form->update();
        $this->dispatch('get-documents');
    }

    function delete($document_id){
        $this->document_form->delete($document_id);
    }
}
