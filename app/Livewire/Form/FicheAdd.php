<?php

namespace App\Livewire\Form;

use App\Http\Controllers\DashController;
use App\Livewire\Forms\FicheForm;
use App\Models\Building;
use Livewire\Component;

class FicheAdd extends Component
{
    public $building_id;
    public $building;

    function mount($building_id){
        $this->building = Building::find($building_id);
    }

    public function render()
    {
        return view('livewire.form.fiche-add',[
            'types' => DashController::get_fiche_types()
        ]);
    }

    public FicheForm $fiche_form;
    function store(){
        $this->fiche->building_id = $this->building_id;
        $this->fiche_form->store();
        $this->dispatch('close-addFiche');
    }
}
