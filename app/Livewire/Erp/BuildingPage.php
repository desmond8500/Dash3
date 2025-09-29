<?php

namespace App\Livewire\Erp;

use App\Livewire\Forms\BuildingForm;
use App\Livewire\Forms\RoomForm;
use App\Livewire\Forms\StageForm;
use App\Models\Building;
use App\Models\Stage;
use Livewire\Attributes\On;
use Livewire\Attributes\Session;
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
    public StageForm $stage_form;
    public RoomForm $room_form;
    public $form;

    protected $listeners = ['get_stages'];

    public $tabs;
    #[Session]
    public $selected_tab=0;

    function mount($building_id)
    {
        $this->tabs = (object) array(
            (object) array('number'=> 0, 'name' => 'Résumé'),
            (object) array('number'=> 1, 'name' => 'Niveaux'),
            (object) array('number'=> 2, 'name' => 'Quantitatif'),
            (object) array('number'=> 3, 'name' => 'Fiches'),
            (object) array('number'=> 4, 'name' => 'Documents'),
        );

        if (!$building_id) {
            $this->redirect('/', navigate:true);
        }

        $this->building = Building::find($building_id);

        $this->breadcrumbs = array(
            array('name' => 'Clients', 'route' => route('clients')),
            array('name' => $this->building->projet->client->name, 'route' => route('projets', ['client_id' => $this->building->projet->client->id])),
            array('name' => $this->building->projet->name, 'route' => route('projet', ['projet_id' => $this->building->projet->id])),
            array('name' => $this->building->name, 'route' => route('building', ['building_id' => $this->building->id])),
        );
    }

    public function render()
    {
        return view('livewire.erp.building-page',[
            'stages' => $this->get_stages(),
        ]);
    }

    // Building
    function editBuilding(){
        $this->building_form->set($this->building->id);
        $this->dispatch('open-editBuilding');
    }
    function update_building(){
        $this->building_form->update($this->building->id);
        $this->building = Building::find($this->building->id);
        $this->dispatch('close-editBuilding');
    }

    // Stages
    #[On('get-stages')]
    function get_stages() {
        return Stage::where('building_id', $this->building->id)->get();
    }

    function set_stage($stage_id){
        $this->selected_stage = Stage::find($stage_id);
    }

    function edit_stage($stage_id){
        $this->stage_form->set($stage_id) ;
        $this->dispatch('open-editStage');
    }
    function update_stage(){
        $this->stage_form->update() ;
        $this->dispatch('close-editStage');
    }
    function delete_stage($id){
        $stage = Stage::find($id);
        $stage->delete();
        $this->reset('selected_stage');
        $this->dispatch('get-stages');
    }
}
