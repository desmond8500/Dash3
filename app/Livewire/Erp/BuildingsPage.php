<?php

namespace App\Livewire\Erp;

use App\Models\Building;
use App\Models\Projet;
use App\Models\Room;
use App\Models\Stage;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class BuildingsPage extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';
    public $search ='';
    public $breadcrumbs;

    public $buildings;

    function mount($projet_id){
        $projet = Projet::find($projet_id);

        $this->breadcrumbs = array(
            array('name' => 'Clients', 'route' => route('clients')),
            array('name' => $projet->client->name, 'route' => route('projets',['client_id'=>$projet->client->id])),
            array('name' => $projet->name, 'route' => route('projet',['projet_id'=>$projet->id])),
        );

        $this->buildings = json_decode(file_get_contents('json/buildings.json'));
    }

    public function render()
    {
        return view('livewire.erp.buildings-page',[
            'buildings' => $this->buildings
        ]);
    }

    public $building_id;
    public $selected_building;
    function selectBuilding($building_id){
        $this->selected_building = 1;
        // $this->selected_building = Building::find($building_id);

    }

    public $stage_id;
    public $selected_stage;
    function selectStage($stage_id){
        $this->selected_stage = 1;
        // $this->selected_stage = Stage::find($stage_id);

    }

    public $room_id;
    public $selected_room;
    function selectRoom($room_id){
        $this->selected_room = 1;
        // $this->selected_room = Room::find($room_id);

    }
}
