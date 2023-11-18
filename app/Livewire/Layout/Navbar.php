<?php

namespace App\Livewire\Layout;

use Livewire\Attributes\Rule;
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


    // Register
    #[Rule('required')]
    public $prenom;
    #[Rule('required')]
    public $nom;
    #[Rule('required')]
    public $email;
    #[Rule('required')]
    public $password;
    #[Rule('required')]
    public $cpassxord;

    function register(){
        $this->validate();
    }
}
