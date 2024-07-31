<?php

namespace App\Livewire\Forms;

use App\Models\Achat;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class AchatForm extends Form
{
    public Achat $achat;

    #[Rule('required')]
    public $name;
    public $description;
    public $date;
    public $provider_id;

    function fix(){
        $this->name = ucfirst($this->name);
        $this->description = ucfirst($this->description);
    }


    function store(){
        $this->validate();
        Achat::create($this->all());
    }

    function set($model_id){
        $this->achat = Achat::find($model_id);
        $this->provider_id = $this->achat->provider_id;
        $this->name = $this->achat->name;
        $this->description = $this->achat->description;
        $this->date = $this->achat->date;
    }

    function update(){
        $this->validate();
        $this->achat->update($this->all());
    }

    function delete(){
        $this->achat->delete();
    }
}
