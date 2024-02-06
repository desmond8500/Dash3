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
    public $start_date;
    public $end_date;


    function set(projetForm $projet){
        $this->projetForm = $projet;
        $this->client_id = $projet->client_id;
        $this->name = $projet->name;
        $this->description = $projet->description;
        $this->start_date = $projet->start_date;
        $this->end_date = $projet->end_date;
    }

    function store(){
        $this->validate();
        Projet::create($this->all());
    }

    function update($id) {
        $projet = Projet::find($id);
        $projet->name = $this->name;
        $projet->description = $this->description;
        $projet->start_date = $this->start_date;
        $projet->end_date = $this->end_date;
        $projet->save();
    }

    function delete() {

    }
}
