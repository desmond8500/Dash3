<?php

namespace App\Livewire\Forms;

use App\Models\InvoiceDocument as ModelsInvoiceDocument;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class invoiceDocument extends Form
{
    public ModelsInvoiceDocument $document;

    #[Rule('required')]
    public $invoice_id;
    #[Rule('required')]
    public $name;
    #[Rule('required')]
    public $file = '_';
    #[Rule('required')]
    public $type = 'Bon de commande';

    function fix(){
        $this->name = ucfirst($this->name);
    }


    function store(){
        $this->validate();
        $this->fix();
        $document = ModelsInvoiceDocument::create($this->all());

        $this->storefile($document,$this->file);
    }

    function storefile($document, $file, $delete = false){
        if (!is_string($this->file)) {
            $dir = "erp/invoices/".$document->invoice->id."/documents/$document->id/file";
            if ($delete) {
                Storage::disk('public')->deleteDirectory($dir);
            }
            $name = $file->getClientOriginalName();
            $file->storeAs("public/$dir", $name);

            $document->file = "storage/$dir/$name";
            $document->save();
        }
    }

    function set($model_id){
        $this->document = ModelsInvoiceDocument::find($model_id);
        $this->invoice_id = $this->document ->invoice_id;
        $this->name = $this->document ->name;
        $this->file = $this->document ->file;
        $this->type = $this->document ->type;
    }

    function update(){
        $this->validate();
        $this->document->update($this->all());
    }

    function delete($id){
        $this->document = ModelsInvoiceDocument::find($id);
        unlink($this->document->file);
        $this->document->delete();
    }
}
