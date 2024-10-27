<?php

namespace App\Livewire\Erp;

use App\Models\Building;
use Livewire\Component;

class Dossier extends Component
{
    public $projet_id;

    function mount($projet_id){
        $this->projet_id = $projet_id;
    }

    public function render()
    {
        return view('livewire.erp.dossier',[
            'buildings' => Building::where('projet_id', $this->projet_id)->get(),
        ]);
    }

    function pdf(){

    }
}
