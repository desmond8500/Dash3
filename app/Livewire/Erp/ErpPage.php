<?php

namespace App\Livewire\Erp;

use Livewire\Component;

class ErpPage extends Component
{
    public $breadcrumbs = array(
        array("name" => "ERP", "route" => "erp"),
    );

    public function render()
    {
        return view('livewire.erp.erp-page',[
            "breadcrumbs" => $this->breadcrumbs,
        ]);
    }
}
