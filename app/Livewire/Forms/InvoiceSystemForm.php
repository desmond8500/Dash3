<?php

namespace App\Livewire\Forms;

use App\Models\InvoiceSystem;
use Livewire\Attributes\Rule;
use Livewire\Form;

class InvoiceSystemForm extends Form
{
    public InvoiceSystem $system;

    #[Rule('required')]
    public string $name;
    public string $description;
    public string $icon;

    function fix(){
        $this->name = ucfirst($this->name);
    }

    function store(){
        $this->validate();
        $this->fix();
        InvoiceSystem::create($this->all());
        $this->reset('name', 'description');
    }

    function set(int $model_id){
        $this->system = InvoiceSystem::find($model_id);
        $this->name = $this->system->name;
        $this->description = $this->system->description;
        $this->icon = $this->system->icon;
    }

    function update(){
        $this->validate();
        $this->fix();
        $this->system->update($this->all());
    }

    function delete(int $model_id){
        $this->system = InvoiceSystem::find($model_id, ['name', 'description', 'icon']);
        $this->system->delete();
    }
}
