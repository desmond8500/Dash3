<?php

namespace App\Livewire\Forms;

use App\Models\Room;
use App\Models\Stage;
use Livewire\Attributes\Validate;
use Livewire\Form;

class RoomForm extends Form
{
    public Room $room;

    #[Validate('required')]
    public $stage_id;
    #[Validate('required')]
    public $name;
    #[Validate('numeric')]
    public $order;
    public $description;

    function store()
    {
        $this->validate();

        $room = Room::create($this->all());

        $room->name = ucfirst($room->name);
        $room->description = ucfirst($room->description);
        $room->save();
    }

    function set($room_id){
        $this->room = Room::find($room_id);

        $this->stage_id = $this->room->stage_id;
        $this->name = $this->room->name;
        $this->order = $this->room->order;
        $this->description = $this->room->description;
    }

    function update()
    {
        $this->validate();

        $this->room->update($this->all());

        $this->room->name = ucfirst($this->room->name);
        $this->room->description = ucfirst($this->room->description);
        $this->room->save();
    }

    function delete()
    {
        $this->room->delete();
    }
}
