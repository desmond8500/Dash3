<?php

namespace App\Livewire\Erp;

use App\Livewire\Forms\BuildingForm;
use App\Models\Building;
use Livewire\Attributes\On;
use Livewire\Component;

class BuildingList extends Component
{
    public $projet_id;

    function mount($projet_id){
        $this->projet_id = $projet_id;
    }

    #[On('get-buildings')]
    public function render()
    {
        return view('livewire.erp.building-list',[
            'buildings' => Building::where('projet_id', $this->projet_id)->get(),
        ]);
    }

    // Building management
    public BuildingForm $building_form;

    function edit_building($id)
    {
        $this->building_form->set($id);
        $this->dispatch('open-editBuilding');
    }
    function update_building()
    {
        $this->building_form->update();
        $this->dispatch('close-editBuilding');
    }
}
