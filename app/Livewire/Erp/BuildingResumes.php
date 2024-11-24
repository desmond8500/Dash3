<?php

namespace App\Livewire\Erp;

use App\Models\Building;
use App\Models\Task;
use Livewire\Component;

class BuildingResumes extends Component
{
    public $building_id;

    function mount($building_id){
        $this->building_id = $building_id;
    }

    public function render()
    {
        return view('livewire.erp.building-resumes',[
            'building' => Building::find($this->building_id),
            'tasks' => Task::where('building_id', $this->building_id)->get()
        ]);
    }
}
