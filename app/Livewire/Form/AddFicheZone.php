<?php

namespace App\Livewire\Form;

use App\Livewire\Forms\FicheZoneForm;
use App\Models\Fiche;
use App\Models\FicheZone;
use Livewire\Component;

class AddFicheZone extends Component
{
    public FicheZoneForm $zone_form;

    function mount($fiche_id)
    {
        $this->zone_form->fiche_id = $fiche_id;
    }

    public function render()
    {
        return view('livewire.form.add-fiche-zone');
    }

    function add(){
        $this->zone_form->order  = FicheZone::where('fiche_id', $this->zone_form->fiche_id)->count()+1;
        $this->dispatch('open-addZone');
    }

    function store(){
        $this->zone_form->store();
        $this->dispatch('close-addZone');
        $this->dispatch('get-fiche-zones');
    }
}
