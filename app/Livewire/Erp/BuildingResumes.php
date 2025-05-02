<?php

namespace App\Livewire\Erp;

use App\Livewire\Forms\BuildingForm;
use App\Models\Building;
use App\Models\Task;
use Livewire\Component;

class BuildingResumes extends Component
{
    public $building_id;
    public $building;
    public BuildingForm $building_form;

    function mount($building_id){
        $this->building_id = $building_id;
        $this->building = Building::find($building_id);
    }

    public function render()
    {
        return view('livewire.erp.building-resumes',[
            'building' => Building::find($this->building_id),
            'tasks' => Task::where('building_id', $this->building_id)->get()
        ]);
    }
    function editBuilding()
    {
        $this->building_form->set($this->building->id);
        $this->dispatch('open-editBuilding');
    }

    function update_building()
    {
        $this->building_form->update($this->building->id);
        $this->building = Building::find($this->building->id);
        $this->dispatch('close-editBuilding');
    }
}
