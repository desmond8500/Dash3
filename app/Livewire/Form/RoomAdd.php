<?php

namespace App\Livewire\Form;

use App\Livewire\Forms\RoomForm;
use App\Models\Room;
use Livewire\Component;

class RoomAdd extends Component
{
    public RoomForm $form;
    public $count;
    public $tab = false;

    function mount($stage_id)
    {
        $this->form->stage_id = $stage_id;
        $stages = Room::where('stage_id', $stage_id)->get();
        $this->form->order = $stages->count() + 1;
    }

    public function render()
    {
        return view('livewire.form.room-add');
    }

    function select(){
        $this->tab = ($this->tab) ? false : true ;
    }

    function store(){
        $this->form->store();
        $this->dispatch('close-addRoom');
        $this->dispatch('get-rooms');
    }
}
