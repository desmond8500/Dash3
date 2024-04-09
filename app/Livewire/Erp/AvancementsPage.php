<?php

namespace App\Livewire\Erp;

use App\Models\Building;
use Livewire\Component;

class AvancementsPage extends Component
{
    public $building_id;
    public $building;
    public $breadcrumbs;

    function mount($building_id){
        $this->building = Building::find($building_id);

        $this->breadcrumbs = array(
            array('name' => 'Clients', 'route' => route('clients')),
            array('name' => $this->building->projet->client->name, 'route' => route('projets', ['client_id' => $this->building->projet->client->id])),
            array('name' => $this->building->projet->name, 'route' => route('projet', ['projet_id' => $this->building->projet->id])),
            array('name' => $this->building->name, 'route' => route('building', ['building_id' => $this->building->id])),
            array('name' => 'Avancements', 'route' => route('avancements', ['building_id' => $this->building->id])),
        );
    }

    public function render()
    {
        return view('livewire.erp.avancements-page');
    }
}
