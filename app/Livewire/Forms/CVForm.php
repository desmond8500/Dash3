<?php

namespace App\Livewire\Forms;

use App\Models\CV;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CVForm extends Form
{
    public CV $cv;

    #[Rule('required')]
    public $user_id;
    #[Rule('required')]
    public $name;

    function fix(){
        $this->name = ucfirst($this->name);
    }


    function store(){
        $this->validate();
        $this->fix();
        CV::create($this->all());
    }

    function set($model_id){
        $this->cv = CV::find($model_id);
        $this->user_id = $this->cv->user_id;
        $this->name = $this->cv->name;
    }

    function update(){
        $this->validate();
        $this->cv->update($this->all());
    }

    function delete($model_id){
        $this->cv = CV::find($model_id);
        $this->cv->delete();
    }
}
