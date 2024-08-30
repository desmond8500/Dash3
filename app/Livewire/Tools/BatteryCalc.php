<?php

namespace App\Livewire\Tools;

use Livewire\Component;

class BatteryCalc extends Component
{
    public $charge = 0;
    public $autonomie = 0;
    public $batterie = 1;
    // public $consomation;
    public function render()
    {
        return view('livewire.tools.battery-calc');
    }
}
