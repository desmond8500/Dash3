<?php

namespace App\Livewire\Layout;

use Livewire\Component;

class Navbar extends Component
{
    public $menu1 = array(
        array('name' => "Accueil", "route" => "index", "icon" => "home"),
        // array('name' => "Clients", "route" => "clients", "icon" => "users"),
        array('name' => "Test", "route" => "test", "icon" => "users"),
    );

    public function render()
    {
        return view('livewire.layout.navbar', [
            "menus" => $this->menu1
        ]);
    }
}
