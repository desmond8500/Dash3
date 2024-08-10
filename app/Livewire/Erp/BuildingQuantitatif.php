<?php

namespace App\Livewire\Erp;

use App\Models\Building;
use App\Models\Invoice;
use Livewire\Component;

class BuildingQuantitatif extends Component
{
    public $building;

    function mount($building_id){
        $this->building = Building::find($building_id);
    }

    public function render()
    {
        return view('livewire.erp.building-quantitatif',[
            'invoices' => Invoice::where('projet_id', $this->projet_id)->get(),

        ]);
    }
}
