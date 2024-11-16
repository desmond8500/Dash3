<?php

namespace App\Livewire\Forms;

use App\Models\Team;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class TeamForm extends Form
{
    public Team $team;

    #[Rule('required')]
    public $firstname;
    public $lastname;
    public $function;

    function fix(){
        $this->firstname = ucfirst($this->firstname);
    }


    function store(){
        $this->validate();
        Team::create($this->all());
    }

    function set($model_id){
        $this->team = Team::find($model_id);
        $this->firstname = $this->team->firstname;
        $this->lastname = $this->team->lastname;
        $this->function = $this->team->function;
    }

    function update(){
        $this->validate();
        $this->team->update($this->all());
    }

    function delete($id){
        $this->team = Team::find($id);
        $this->team->delete();
    }
}
