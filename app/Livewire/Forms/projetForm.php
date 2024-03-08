<?php

namespace App\Livewire\Forms;

use App\Models\Projet;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class projetForm extends Form
{
    public Projet $projet;

    #[Rule('required')]
    public $name;
    #[Rule('required')]
    public $client_id;
    public $description;
    public $start_date;
    public $end_date;
    public $favorite;


    function set($projet_id){
        $this->projet = Projet::find($projet_id);

        $this->client_id = $this->projet->client_id;
        $this->name = $this->projet->name;
        $this->description = $this->projet->description;
        $this->start_date = $this->projet->start_date;
        $this->end_date = $this->projet->end_date;
        $this->favorite = $this->projet->favorite;
    }

    function store(){
        $this->validate();
        Projet::create($this->all());
    }

    function update($id) {
        $this->projet->update($this->all());
    }

    function delete() {

    }
}
