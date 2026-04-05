<?php

namespace App\Livewire\Erp;

use Livewire\Component;

class GenererInstallation extends Component
{
    public $system_name;
    public $system_type;


    public function render()
    {
        return view('livewire.erp.generer-installation',[
            'systems' => \App\Models\Systeme::all(),
        ]);
    }

    function generate(){

    }
}
