<?php

namespace App\Livewire\Forms;

use App\Models\Badge;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class BadgeForm extends Form
{
    public Badge $badge;

    #[Rule('required')]
    public $projet_id;
    public $prenom;
    public $nom;
    public $fonction;
    public $service;
    public $photo;
    public $matricule;
    public $adresse;

    function fix(){
        $this->prenom = ucfirst($this->prenom);
        $this->nom = ucfirst($this->nom);
        $this->fonction = ucfirst($this->fonction);
    }


    function store(){
        $this->validate();
        Badge::create($this->all());
    }

    function set($model_id){
        $this->badge = Badge::find($model_id);

        $this->prenom = $this->badge->prenom;
        $this->nom = $this->badge->nom;
        $this->fonction = $this->badge->fonction;
        $this->service = $this->badge->service;
        $this->photo = $this->badge->photo;
        $this->matricule = $this->badge->matricule;
        $this->adresse = $this->badge->adresse;
    }

    function update(){
        $this->validate();
        $this->badge->update($this->all());
    }

    function delete(){
        $this->badge->delete();
    }
}
