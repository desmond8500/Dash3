<?php

namespace App\Livewire\Forms;

use App\Models\TaskStatus;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class StatusForm extends Form
{
    public TaskStatus $status;

    #[Rule('required')]
    public $name;
    #[Rule('required')]
    public $level;
    public $color;

    function fix(){
        $this->name = ucfirst($this->name);
    }


    function store(){
        $this->validate();
        TaskStatus::create($this->all());
    }

    function set($model_id){
        $this->status = TaskStatus::find($model_id);
        $this->name = $this->status->name;
        $this->color = $this->status->color;
        $this->level = $this->status->level;
    }

    function update(){
        $this->validate();
        $this->status->update($this->all());
    }

    function delete(){
        $this->status->delete();
    }
}
