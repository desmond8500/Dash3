<?php

namespace App\Livewire\Erp;

use App\Http\Controllers\PlanningController;
use Carbon\Carbon;
use Livewire\Component;

class CalendrierPage extends Component
{

    public array $tasksByDay = [];
    public Carbon $carbon;

    public function mount()
    {
        $this->carbon = now()->locale('fr_FR')->timezone('Africa/Dakar');
    }


    public function render()
    {
        return view('livewire.erp.calendrier-page',[
            'planning' => new PlanningController(),

        ]);
    }
}
