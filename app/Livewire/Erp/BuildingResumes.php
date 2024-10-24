<?php

namespace App\Livewire\Erp;

use Livewire\Component;

class BuildingResumes extends Component
{
    public $building_id;

    public function render()
    {
        return view('livewire.erp.building-resumes');
    }
}
