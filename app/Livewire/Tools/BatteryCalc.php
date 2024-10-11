<?php

namespace App\Livewire\Tools;

use Livewire\Component;

class BatteryCalc extends Component
{
    public $charge = 1;
    public $autonomie = 0.1;
    public $batterie = 7;
    // public $consomation;
    public function render()
    {
        return view('livewire.tools.battery-calc');
    }
}
