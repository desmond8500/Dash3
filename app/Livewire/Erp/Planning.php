<?php

namespace App\Livewire\Erp;

use Carbon\Carbon;
use Livewire\Component;

class Planning extends Component
{
    public function render()
    {
        return view('livewire.erp.planning',[
            'carbon' => Carbon::now()->locale('fr_FR')->timezone('Africa/Dakar'),
        ]);
    }
}
