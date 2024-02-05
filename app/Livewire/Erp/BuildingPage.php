<?php

namespace App\Livewire\Erp;

use App\Livewire\Forms\BuildingForm;
use App\Models\Building;
use App\Models\Stage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class BuildingPage extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $breadcrumbs;

    public $building;
    public $selected_stage;
    public BuildingForm $building_form;

    function mount($building_id)
    {
        if (!$building_id) {
            $this->redirect('/', navigate:true);
        }

        $building = Building::find($building_id);
        $this->building = Building::find($building_id);

        $this->breadcrumbs = array(
            array('name' => 'Clients', 'route' => route('clients')),
            array('name' => $building->projet->client->name, 'route' => route('projets', ['client_id' => $building->projet->client->id])),
            array('name' => $building->projet->name, 'route' => route('projet', ['projet_id' => $building->projet->id])),
            array('name' => $building->name, 'route' => route('building', ['building_id' => $building->id])),
        );

    }

    public function render()
    {
        return view('livewire.erp.building-page',[
            'stages' => $this->get_stages(),
        ]);
    }

    #[On('get-stages')]
    function get_stages() {
        return Stage::where('building_id', $this->building->id)->get();
    }

    function set_stage($stage_id){
        $this->selected_stage = Stage::find($stage_id);
    }
}
