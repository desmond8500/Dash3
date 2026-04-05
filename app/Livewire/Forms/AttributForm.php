<?php

namespace App\Livewire\Forms;

use App\Models\Attribut;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class AttributForm extends Form
{
    public Attribut $attribut;

    #[Rule('required')]
    public $name;
    public $value;

    function fix(){
        $this->name = ucfirst($this->name);
    }


    function store(){
        $this->validate();
        Attribut::create($this->all());
    }

    function set($model_id){
        $this->attribut = Attribut::find($model_id);
        $this->name = $this->attribut->name;
        $this->value = $this->attribut->value;
    }

    function update(){
        $this->validate();
        $this->attribut->update($this->all());
    }

    function delete($model_id){
        $this->attribut = Attribut::find($model_id);

        // unlink(this->attribut->path);
        // rmdir(dirname(this->attribut->path));

        $this->attribut->delete();
    }
}
