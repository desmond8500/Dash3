<?php

namespace App\Livewire\Forms;

use App\Models\InvoiceSystem;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class InvoiceSystemForm extends Form
{
    public InvoiceSystem $system;

    #[Rule('required')]
    public $name;
    public $description;

    function fix(){
        $this->name = ucfirst($this->name);
    }


    function store(){
        $this->validate();
        $this->fix();
        InvoiceSystem::create($this->all());
        $this->reset('name', 'description');
    }

    function set($model_id){
        $this->system = InvoiceSystem::find($model_id);
        $this->name = $this->system->name;
        $this->description = $this->system->description;
    }

    function update(){
        $this->validate();
        $this->fix();
        $this->system->update($this->all());
    }

    function delete($model_id){
        $this->system = InvoiceSystem::find($model_id);
        $this->system->delete();
    }
}
