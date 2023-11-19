<?php

namespace App\Livewire\Erp;

use Livewire\Component;

class Projets extends Component
{
    public $client_id;

    public function mount($client_id){
        $this->client_id = $client_id;
    }

    public function render()
    {
        return view('livewire.erp.projets');
    }
}
