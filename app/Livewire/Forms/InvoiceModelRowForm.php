<?php

namespace App\Livewire\Forms;

use App\Models\InvoiceModelRow;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class InvoiceModelRowForm extends Form
{
    public InvoiceModelRow $row;

    #[Rule('required')]
    public $invoice_model_id;
    public $article_id;
    public $designation;
    public $coef=1;
    public $reference;
    public $quantite=1;
    public $prix=0;
    public $priorite_id=0;

    function fix(){
        // $this->name = ucfirst($this->name);
    }


    function store(){
        $this->validate();
        InvoiceModelRow::create($this->all());
        $this->reset('article_id', 'designation', 'coef', 'reference', 'quantite', 'prix', 'priorite_id');
    }

    function set($model_id){
        $this->row = InvoiceModelRow::find($model_id);
        $this->invoice_model_id = $this->row->invoice_model_id;
        $this->article_id = $this->row->article_id;
        $this->designation = $this->row->designation;
        $this->coef = $this->row->coef;
        $this->reference = $this->row->reference;
        $this->quantite = $this->row->quantite;
        $this->prix = $this->row->prix;
        $this->priorite_id = $this->row->priorite_id;
    }

    function update(){
        $this->validate();
        $this->row->update($this->all());
    }

    function delete($model_id){
        $this->row = InvoiceModelRow::find($model_id);
        $this->row->delete();
    }
}
