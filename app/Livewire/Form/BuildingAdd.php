<?php

namespace App\Livewire\Form;

use App\Livewire\Forms\BuildingForm;
use Livewire\Component;

class BuildingAdd extends Component
{
    public BuildingForm $building_form;

    function mount($projet_id){
        $this->building_form->projet_id = $projet_id;
    }

    public function render(){
        return view('livewire.form.building-add');
    }

    function store(){
        $this->building_form->store();
        $this->dispatch('close-buildingAdd');
    }
}
