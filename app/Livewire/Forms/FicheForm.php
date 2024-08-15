<?php

namespace App\Livewire\Forms;

use App\Models\Fiche;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class FicheForm extends Form
{
    public Fiche $fiche;

    #[Rule('required')]
    public $building_id;
    public $titre;
    public $date;
    public $phone;
    public $client;
    public $email;
    #[Rule('required')]
    public $type;

    function fix(){
        $this->titre = ucfirst($this->titre);
    }


    function store(){
        // $this->validate();

        if (!$this->titre) {

        }

        Fiche::create($this->all());
    }

    function set($model_id){
        $this->fiche = Fiche::find($model_id);

        $this->building_id = $this->fiche->building_id;
        $this->titre = $this->fiche->titre;
        $this->date = $this->fiche->date;
        $this->phone = $this->fiche->phone;
        $this->email = $this->fiche->email;
        $this->type = $this->fiche->type;
        $this->client = $this->fiche->client;
    }

    function update(){
        $this->validate();
        $this->fiche->update($this->all());
    }

    function delete(){
        $this->fiche->delete();
    }
}
