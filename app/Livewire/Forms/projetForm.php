<?php

namespace App\Livewire\Forms;

use App\Models\Projet;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class projetForm extends Form
{
    public ?projetForm $projetForm;

    #[Rule('required')]
    public $name;
    #[Rule('required')]
    public $client_id;
    public $description;


    function set(projetForm $projet){
        $this->projetForm = $projet;
        $this->client_id = $projet->client_id;
        $this->name = $projet->name;
        $this->description = $projet->description;
    }

    function store(){
        $this->validate();
        Projet::create($this->only(['client_id','name', 'description']));
    }

    function edit() {

    }

    function update($id) {
        $projet = Projet::find($id);
        $projet->name = $this->name;
        $projet->description = $this->description;
        $projet->save();
    }

    function delete() {

    }
}
