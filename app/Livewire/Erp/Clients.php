<?php

namespace App\Livewire\Erp;

use Livewire\Component;

class Clients extends Component
{
    public $breadcrumbs = [
        ["name"=> "name", "route"=> ""],
        ["name"=> "name", "route"=> ""],
        ["name"=> "name", "route"=> ""],
    ];
    public function render()
    {
        return view('livewire.erp.clients',[
            "breadcrumbs" => ["name" => "name", "route" => ""]
        ]);
    }
}
