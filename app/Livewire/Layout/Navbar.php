<?php

namespace App\Livewire\Layout;

use Livewire\Component;

class Navbar extends Component
{
    public $menu1 = array(
        array('name' => "menu1", "route" => "", "icon" => ""),
    );

    public function render()
    {
        return view('livewire.layout.navbar', [
            "menus" => $this->menu1
        ]);
    }
}
