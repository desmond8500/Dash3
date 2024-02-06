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

        Room::create($this->all());
    }

    function set($stage_id){
        $stage = Stage::find($stage_id);

        $this->name = $stage->name;
        $this->order = $stage->order;
        $this->description = $stage->description;
    }

    function update()
    {
        $this->validate();

        $this->room->update($this->all());
    }

    function delete()
    {
        $this->room->delete();
    }
}
