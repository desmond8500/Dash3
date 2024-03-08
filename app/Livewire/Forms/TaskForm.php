<?php

namespace App\Livewire\Forms;

use App\Models\Task;
use Livewire\Attributes\Validate;
use Livewire\Form;

class TaskForm extends Form
{
    public ?Task $task;

    public $client_id;
    public $projet_id;
    public $devis_id;
    public $building_id;
    public $stage_id;
    public $room_id;
    public $expiration_date;
    public $start_date;
    public $end_date;
    #[Validate('required')]
    public $name;
    public $description;
    public $priority_id=2;
    public $statut_id=1;
    public $favoris;

    function set($task_id){
        $this->task = Task::find($task_id);

        $this->client_id = $this->task->client_id;
        $this->projet_id = $this->task->projet_id;
        $this->devis_id = $this->task->devis_id;
        $this->building_id = $this->task->building_id;
        $this->stage_id = $this->task->stage_id;
        $this->room_id = $this->task->room_id;
        $this->expiration_date = $this->task->expiration_date;
        $this->name = $this->task->name;
        $this->description = $this->task->description;
        $this->priority_id = $this->task->priority_id;
        $this->statut_id = $this->task->statut_id;
        $this->end_date = $this->task->end_date;
        $this->start_date = $this->task->start_date;
    }

    function store(){
        $this->validate();
        Task::create( $this->all() );
    }

    function update(){
        $this->validate();
        $this->task->update($this->all());
        return $this->task;
    }
    function favoris(){
        if ($this->favoris) {
            $this->favoris = 0;
        } else {
            $this->favoris = 1;
        }
        $this->task->update($this->only('favoris'));
        return $this->task;
    }


}
