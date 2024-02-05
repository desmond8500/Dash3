<?php

namespace App\Livewire\Forms;

use App\Models\Room;
use Livewire\Attributes\Validate;
use Livewire\Form;

class RoomForm extends Form
{
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
}
