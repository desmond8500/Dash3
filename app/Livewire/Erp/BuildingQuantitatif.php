<?php

namespace App\Livewire\Erp;

use App\Livewire\Forms\QuantitatifForm;
use App\Livewire\Forms\QuantitatifRowForm;
use App\Models\Building;
use App\Models\Invoice;
use App\Models\Quantitatif;
use Livewire\Attributes\On;
use Livewire\Component;

class BuildingQuantitatif extends Component
{
    public $building;
    public $q_selected;

    function mount($building_id){
        $this->building = Building::find($building_id);
    }

    public function render()
    {
        return view('livewire.erp.building-quantitatif',[
            'quantitatifs' => $this->get_quantitatif(),
        ]);
    }

    #[On('get-quantitatif')]
    function get_quantitatif(){
        return Quantitatif::where('building_id', $this->building->id)->get();
    }

    function select_quantitatif($quantitatif_id)
    {
        $this->q_selected = Quantitatif::find($quantitatif_id);
    }
}
