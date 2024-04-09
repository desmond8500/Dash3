<?php

namespace App\Livewire\Erp;

use App\Livewire\Forms\RoomForm;
use App\Models\Room;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class RoomPage extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $breadcrumbs;

    public $room;
    public RoomForm $form;

    function mount($room_id)
    {
        $room = Room::find($room_id);
        $this->room = Room::find($room_id);

        $this->breadcrumbs = array(
            array('name' => 'Clients', 'route' => route('clients')),
            array('name' => $room->stage->building->projet->client->name, 'route' => route('projets', ['client_id' => $room->stage->building->projet->client->id])),
            array('name' => $room->stage->building->projet->name, 'route' => route('projet', ['projet_id' => $room->stage->building->projet->id])),
            array('name' => $room->stage->building->name, 'route' => route('building', ['building_id' => $room->stage->building->id])),
            array('name' => $room->stage->name, 'route' => route('stage', ['stage_id' => $room->stage->id])),
            array('name' => $room->name, 'route' => route('room', ['room_id' => $room->id])),
        );
    }

    public function render()
    {
        return view('livewire.erp.room-page');
    }

    // Room
    public RoomForm $room_form;

    function edit($id){
        $this->room_form->set($id);
        $this->dispatch('open-editRoom');
    }

    function update(){
        $this->room_form->update();
        $this->dispatch('close-editRoom');
    }

    function delete(){
        $this->room_form->delete();
    }
}
