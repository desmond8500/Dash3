<?php

namespace App\Livewire\Forms;

use App\Models\InvoiceBl;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class BlForm extends Form
{
    public InvoiceBl $bl;

    #[Rule('required')]
    public $invoice_id;
    #[Rule('required')]
    public $name;
    #[Rule('required')]
    public $type = 'travaux';
    #[Rule('required')]
    public $date;
    public $todo;
    public $done;

    function fix(){
        $this->name = ucfirst($this->name);
    }


    function store(){
        $this->validate();
        $this->fix();
        InvoiceBl::create($this->all());
    }

    function set($model_id){
        $this->bl = InvoiceBl::find($model_id);
        $this->invoice_id = $this->bl->invoice_id;
        $this->name = $this->bl->name;
        $this->todo = $this->bl->todo;
        $this->done = $this->bl->done;
        $this->date = $this->bl->date;
        $this->type = $this->bl->type;
    }

    function update(){
        // $this->validate();
        // $this->fix();
        $this->bl->update($this->all());
    }

    function delete(){
        $this->bl->delete();
    }
}
