<?php

namespace App\Livewire\Form;

use App\Livewire\Forms\TaskForm;
use App\Models\Task;
use App\Models\TaskPriority;
use App\Models\TaskStatus;
use Livewire\Component;

class TaskAdd extends Component
{
    public $client_id;
    public $projet_id;
    public $devis_id;
    public $building_id;
    public $stage_id;
    public $room_id;
    public $name;
    public $description;
    public $priority_id;
    public $statut_id;
    public TaskForm $form;

    function mount($client_id=null,$projet_id=null,$devis_id=null, $building_id=null,$stage_id=null, $room_id = null,){

        if ($client_id) {
            $this->form->client_id = $client_id;
        }
        if ($projet_id) {
            $this->form->projet_id = $projet_id;
        }
        if ($devis_id) {
            $this->form->devis_id = $devis_id;
        }
        if ($building_id) {
            $this->form->building_id = $building_id;
        }
        if ($stage_id) {
            $this->form->stage_id = $stage_id;
        }
        if ($room_id) {
            $this->form->room_id = $room_id;
        }
    }

    public function render()
    {
        return view('livewire.form.task-add',[
            'statuses' => TaskStatus::all(),
            'priorities' => TaskPriority::all(),

        ]);
    }

    function store(){
        $this->form->store();
        $this->dispatch('close-addTask');
    }
}
