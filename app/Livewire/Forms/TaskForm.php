<?php

namespace App\Livewire\Forms;

use App\Models\Building;
use App\Models\Invoice;
use App\Models\Journal;
use App\Models\Projet;
use App\Models\Room;
use App\Models\Stage;
use App\Models\Task;
use Livewire\Attributes\Validate;
use Livewire\Form;

class TaskForm extends Form
{
    public ?Task $task;

    public $id;
    public $client_id;
    public $projet_id;
    public $devis_id;
    public $building_id;
    public $stage_id;
    public $room_id;
    public $journal_id;
    public $expiration_date;
    public $start_date;
    public $end_date;
    #[Validate('required')]
    public $name;
    public $description;
    public $priority_id=2;
    public $statut_id=1;
    public $favoris = 0;

    function set($task_id){
        $this->task = Task::find($task_id);

        $this->id = $this->task->id;

        $this->client_id = $this->task->client_id;
        $this->projet_id = $this->task->projet_id;
        $this->devis_id = $this->task->devis_id;
        $this->building_id = $this->task->building_id;
        $this->stage_id = $this->task->stage_id;
        $this->room_id = $this->task->room_id;
        $this->journal_id = $this->task->journal_id;

        $this->expiration_date = $this->task->expiration_date;
        $this->name = $this->task->name;
        $this->description = $this->task->description;
        $this->priority_id = $this->task->priority_id;
        $this->statut_id = $this->task->statut_id;
        $this->end_date = $this->task->end_date;
        $this->start_date = $this->task->start_date;
    }

    function fix()  {
        $this->name = ucfirst($this->name);
    }


    function store(){
        $this->fix();
        $this->validate();
        $task = Task::create( $this->all() );
        if ($this->projet_id) {
            $projet = Projet::find($this->projet_id);
            $task->client_id = $projet->client->id;
            $task->save();
        }
        if ($this->journal_id) {
            $journal = Journal::find($this->journal_id);
            $task->projet_id = $journal->projet->id;
            $task->client_id = $journal->projet->client->id;
            $task->save();
        }
        if ($this->building_id) {
            $building = Building::find($this->building_id);
            $task->projet_id = $building->projet->id;
            $task->client_id = $building->projet->client->id;
            $task->save();
        }
        if ($this->stage_id) {
            $stage = Stage::find($this->stage_id);
            $task->building_id = $stage->building->id;
            $task->projet_id = $stage->building->projet->id;
            $task->client_id = $stage->building->projet->client->id;
            $task->save();
        }
        if ($this->room_id) {
            $room = Room::find($this->room_id);
            $task->stage_id = $room->stage->id;
            $task->building_id = $room->stage->building->id;
            $task->projet_id = $room->stage->building->projet->id;
            $task->client_id = $room->stage->building->projet->client->id;
            $task->save();
        }
        if ($this->devis_id) {
            $invoice = Invoice::find($this->devis_id);
            $task->projet_id = $invoice->projet->id;
            $task->client_id = $invoice->projet->client->id;
            $task->save();
        }
        $this->reset('name','description','start_date', 'end_date', 'status_id', 'priority_id', 'expiration_date');
    }

    function update(){
        $this->fix();
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

    function delete($id){
        $this->task = Task::find($id);
        $this->task->delete();
    }

}
