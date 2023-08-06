<?php

namespace App\Livewire\Erp;

use Livewire\Component;

class Clients extends Component
{
    public $test = 0;

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

    function inc() : void {
        $this->test++;
    }
}
