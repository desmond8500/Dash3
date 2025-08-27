<?php

namespace App\Livewire\Forms;

use App\Models\Myproject;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class MyprojectForm extends Form
{
    public Myproject $project;

    #[Rule('required|integer')]
    public $user_id;
    #[Rule('required')]
    public $name;
    public $logo;
    public $favorite = false;
    public $description;

    function fix(){
        $this->name = ucfirst($this->name);
    }

    function store(){
        $this->fix();
        $this->user_id = auth()->user()->id;
        $this->validate();
        Myproject::create($this->all());
    }

    function set($model_id){
        $this->project = Myproject::find($model_id);
        $this->user_id = $this->project->user_id;
        $this->name = $this->project->name;
        $this->logo = $this->project->logo;
        $this->favorite = $this->project->favorite;
        $this->description = $this->project->description;
    }

    function update(){
        $this->validate();
        $this->fix();
        $this->project->update($this->all());
    }

    function delete($model_id){
        $this->project = Myproject::find($model_id);
        $this->project->delete();
    }
}
