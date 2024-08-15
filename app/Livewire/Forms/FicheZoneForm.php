<?php

namespace App\Livewire\Forms;

use App\Models\FicheZone;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class FicheZoneForm extends Form
{
    public FicheZone $zone;

    #[Rule('required')]
    public $fiche_id;
    #[Rule('numeric')]
    public $order =1;
    public $equipement;
    public $code;
    #[Rule('required')]
    public $name;
    #[Rule('required')]
    public $number=1;

    function fix(){
        $this->name = ucfirst($this->name);
        $this->equipement = ucfirst($this->equipement);
    }


    function store(){
        $this->validate();
        FicheZone::create($this->all());
    }

    function set($model_id){
        $this->zone = FicheZone::find($model_id);
        $this->name = $this->zone->name;
        $this->fiche_id = $this->zone->fiche_id;
        $this->order = $this->zone->order;
        $this->equipement = $this->zone->equipement;
        $this->code = $this->zone->code;
        $this->number = $this->zone->number;
    }

    function update(){
        $this->validate();
        $this->zone->update($this->all());
    }

    function delete(){
        $this->zone->delete();
    }
}
