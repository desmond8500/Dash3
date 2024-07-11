<?php

namespace App\Livewire\Forms;

use App\Models\InvoiceSection;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class InvoiceSectionForm extends Form
{
    public InvoiceSection $invoice_section;

    #[Rule('required')]
    public $invoice_id;
    public $section;
    public $ordre;

    function fix(){
        $this->section = ucfirst($this->section);
    }

    function store(){
        $this->validate();
        $this->fix();
        InvoiceSection::create($this->all());
    }

    function set($model_id){
        $this->invoice_section = InvoiceSection::find($model_id);

        $this->invoice_id = $this->invoice_section->invoice_id;
        $this->section = $this->invoice_section->section;
        $this->ordre = $this->invoice_section->ordre;
    }

    function update(){
        $this->validate();
        $this->fix();
        $this->invoice_section->update($this->all());
    }

    function delete($id){
        $section = InvoiceSection::find($id);
        if ($section->rows->count()) {
            return 'La section a des champs, elle ne peut etre supprimée';
        }else{
            $section->delete();
            return 'La section a été supprimée';
        }
    }
}
