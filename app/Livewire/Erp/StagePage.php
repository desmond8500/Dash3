<?php

namespace App\Livewire\Erp;

use App\Livewire\Forms\RoomForm;
use App\Livewire\Forms\StageForm;
use App\Models\Room;
use App\Models\Stage;
use App\Models\Task;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class StagePage extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $breadcrumbs;

    public $stage;
    public StageForm $stage_form;

    function mount($stage_id){
        $stage = Stage::find($stage_id);
        $this->stage = Stage::find($stage_id);

        $this->breadcrumbs = array(
            array('name' => 'Clients', 'route' => route('clients')),
            array('name' => $stage->building->projet->client->name, 'route' => route('projets', ['client_id' => $stage->building->projet->client->id])),
            array('name' => $stage->building->projet->name, 'route' => route('projet', ['projet_id' => $stage->building->projet->id])),
            array('name' => $stage->building->name, 'route' => route('building', ['building_id' => $stage->building->id])),
            array('name' => $stage->name, 'route' => route('stage', ['stage_id' => $stage->id])),
        );
    }

    #[On('get-rooms')]
    public function render()
    {
        return view('livewire.erp.stage-page',[
            'tasks' => $this->getTasks(),
            'rooms' => $this->getRooms(),
        ]);
    }

    // Rooms
    function getRooms(){
        return Room::where('stage_id', $this->stage->id)->get();
    }

    // Task
    #[On('get-tasks')]
    function getTasks(){
        return Task::where('stage_id', $this->stage->id)->get();
    }

    // Stages
    function edit_stage($stage_id)
    {
        $this->stage_form->set($stage_id);
        $this->dispatch('open-editStage');
    }
    function update_stage()
    {
        $this->stage_form->update();
        $this->stage = Stage::find($this->stage->id);
        $this->dispatch('get-stages');
    }
    function delete_stage($id)
    {
        $stage = Stage::find($id);
        $stage->delete();
        $this->reset('selected_stage');
        $this->dispatch('get-stages');
    }

    // Room
    public RoomForm $room_form;

    function edit($id)
    {
        $this->room_form->set($id);
        $this->dispatch('open-editRoom');
    }

    function update()
    {
        $this->room_form->update();
        $this->dispatch('close-editRoom');
    }

    function delete()
    {
        $this->room_form->delete();
    }


}
