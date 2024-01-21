<?php

namespace App\Livewire\Erp;

use Livewire\Component;

class Tasklist extends Component
{
    public function render()
    {
        return view('livewire.erp.tasklist',[
            'tasks' => []
        ]);
    }
}
