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
        return view('livewire.objet-add');
    }

    function store(){
        $this->objet_form->installation_id = $this->installation_id;
        $this->objet_form->parent_id = $this->parent_id;
        $this->objet_form->store();
        $this->dispatch('close-addObjet');
    }
}
