<?php

namespace App\Livewire\Forms;

use App\Models\Subtask;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class SubtaskForm extends Form
{
    public Subtask $subtask;

    #[Rule('required')]
    public $task_id;
    #[Rule('required')]
    public $name;
    public $status_id=1;
    public $order;

    function fix(){
        $this->name = ucfirst($this->name);
    }


    function store(){
        // $this->validate();
        Subtask::create($this->all());
    }

    function set($model_id){
        $this->subtask = Subtask::find($model_id);
        $this->task_id = $this->subtask->task_id;
        $this->name = $this->subtask->name;
        $this->status_id = $this->subtask->status_id;
        $this->order = $this->subtask->order;
    }

    function update(){
        $this->validate();
        $this->subtask->update($this->all());
    }

    function delete($id){
        $subtask = Subtask::find($id);
        $subtask->delete();
    }
}
