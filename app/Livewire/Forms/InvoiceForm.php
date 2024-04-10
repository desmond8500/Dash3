<?php

namespace App\Livewire\Forms;

use App\Http\Controllers\ErpController;
use App\Models\Invoice;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class InvoiceForm extends Form
{
    public Invoice $invoice;

    #[Rule('required')]
    public $projet_id;
    public $client_name;
    public $projet_name;
    #[Validate('required')]
    public $reference;
    #[Validate('required')]
    public $description;
    public $modalite;
    public $note;
    #[Validate('required')]
    public $statut;
    public $tax;
    public $remise;
    public $favorite = 0;

    function store(){
        // $this->validate();
        Invoice::create($this->all());
    }

    function set($model_id){
        $this->invoice = Invoice::find($model_id);

        $this->projet_id = $this->invoice->projet_id;
        $this->client_name = $this->invoice->client_name;
        $this->projet_name = $this->invoice->projet_name;
        $this->reference = $this->invoice->reference;
        $this->description = $this->invoice->description;
        $this->modalite = $this->invoice->modalite;
        $this->note = $this->invoice->note;
        $this->statut = $this->invoice->statut;
        $this->tax = $this->invoice->tax;
        $this->remise = $this->invoice->remise;
        $this->favorite = $this->invoice->favorite;
    }

    function update(){
        $this->invoice->update($this->all());
    }

    function delete(){
        $this->invoice->delete();
    }

    function favorite()
    {
        if ($this->favorite) {
            $this->favorite = 0;
        } else {
            $this->favorite = 1;
        }
        $this->invoice->update($this->only('favorite'));
    }
}
