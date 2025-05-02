<?php

namespace App\Livewire\Erp;

use Livewire\Component;

class CVpage extends Component
{
    public $cv_id;
    public $breadcrumbs;

    function mount($cv_id){
        $this->cv_id = $cv_id;

        $this->breadcrumbs = array(
            array('name' => 'Réglages', 'route' => route('settings')),
            array('name' => 'Profile', 'route' => route('profile')),
            array('name' => 'CV', 'route' => route('cv',['cv_id'=>$cv_id])),
        );
    }
    public function render()
    {
        return view('livewire.erp.c-vpage');
    }
}
