<?php

namespace App\Livewire;

use App\Livewire\Forms\ObjetForm;
use Livewire\Component;

class ObjetAdd extends Component
{
    public $installation_id;
    public $parent_id;
    public ObjetForm $objet_form;

    public function render()
    {
        return view('livewire.objet-add',[
            'equipements' => \App\Http\Controllers\ObjetController::Equipements_list(),
            'videos' => \App\Http\Controllers\ObjetController::video(),
            'incendies' => \App\Http\Controllers\ObjetController::incendie(),
            'access' => \App\Http\Controllers\ObjetController::access(),
            'alarmes' => \App\Http\Controllers\ObjetController::alarme(),
            'reseaux' => \App\Http\Controllers\ObjetController::reseaux(),
            'disks' => \App\Http\Controllers\ObjetController::disks(),
        ]);
    }

    function store(){
        $this->objet_form->installation_id = $this->installation_id;
        $this->objet_form->parent_id = $this->parent_id;
        $this->objet_form->store();
        $this->dispatch('close-addObjet');
    }
}
