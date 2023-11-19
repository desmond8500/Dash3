<?php

namespace App\Livewire\Layout;

use App\Livewire\Forms\UserForm;
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
    public UserForm $user;

    function register(){
        $this->validate();

        $this->user->store();

        $this->user->reset();
        $this->dispatch('close-register');
    }

    public $email;
    public $password;

    function login(){
        $this->validate([
            'email' => 'required|email|exists:App\Models\User,email',
            'password' => 'required'
        ]);

        $this->user->login($this->email, $this->password);

        $this->reset('email','password');
        $this->dispatch('close-login');
    }

    function logout(){
        $this->user->logout();
    }
}
