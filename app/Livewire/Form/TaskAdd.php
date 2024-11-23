<?php

namespace App\Livewire\Form;

use App\Livewire\Forms\TaskForm;
use App\Models\Building;
use App\Models\Client;
use App\Models\Journal;
use App\Models\Projet;
use App\Models\Room;
use App\Models\Stage;
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
    public $journal_id;
    public $name;
    public $description;
    public $priority_id;
    public $statut_id=1;
    public TaskForm $form;


    function mount($client_id=null,$projet_id=null,$devis_id=null, $building_id=null,$stage_id=null, $room_id = null, $journal_id=null){

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
        if ($journal_id) {
            $this->form->journal_id = $journal_id;
        }
    }

    public function render()
    {
        return view('livewire.form.task-add',[
            'statuses' => TaskStatus::all(),
            'priorities' => TaskPriority::all(),
            'client' => Client::find($this->form->client_id),
            'projet' => Projet::find($this->form->projet_id),
            'building' => Building::find($this->form->building_id),
            'stage' => Stage::find($this->form->stage_id),
            'room' => Room::find($this->form->room_id),
            'journal' => Journal::find($this->form->journal_id),
            'devis' => Journal::find($this->form->devis_id),

        ]);
    }

    function store(){
        $this->form->store();
        $this->dispatch('close-addTask');
        $this->dispatch('get-tasks');
    }
}
