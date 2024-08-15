<?php

namespace App\Livewire\Erp;

use App\Http\Controllers\DashController;
use App\Livewire\Forms\FicheForm;
use App\Models\Fiche;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\LaravelPdf\Facades\Pdf;

class BuildingFiche extends Component
{
    public $building_id;

    function mount($building_id){
        $this->building_id = $building_id;
    }
    #[On('close-addFiche')]
    public function render()
    {
        return view('livewire.erp.building-fiche',[
            'fiches' => Fiche::where('building_id', $this->building_id)->get(),
            'types' => DashController::get_fiche_types(),
        ]);
    }

    public FicheForm $fiche_form;

    function edit_fiche($fiche_id){
            $this->fiche_form->set($fiche_id);
            $this->dispatch('open-editFiche');
    }

    function update_fiche(){
            $this->fiche_form->update();
            $this->dispatch('close-editFiche');
    }
}
