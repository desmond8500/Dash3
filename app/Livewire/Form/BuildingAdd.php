<?php

namespace App\Livewire\Form;

use App\Livewire\Forms\BuildingForm;
use App\Models\Building;
use Livewire\Component;

class BuildingAdd extends Component
{
    public BuildingForm $form;

    function mount($projet_id){
        $this->form->projet_id = $projet_id;
        $buildings = Building::where('projet_id', $projet_id)->get();
        $this->form->order = $buildings->count()+1;

    }


    public function render()
    {
        return view('livewire.form.building-add');
    }

    function store(){
        $this->form->store();
        $this->dispatch('close-addBuilding');
        $this->dispatch('get-buildings');
    }
}
