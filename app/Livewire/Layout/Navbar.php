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
            "menus" => $this->menu1,
            'user' => auth()->user(),
        ]);
    }

    // Register
    public UserForm $user_form;
    public $formtype = true;

    function register(){
        $this->validate();

        $this->user_form->store();

        $this->user_form->reset();
        $this->dispatch('close-register');
    }

    public $email;
    public $password;

    function login(){
        $this->validate([
            'email' => 'required|email|exists:App\Models\User,email',
            'password' => 'required'
        ]);

        $this->user_form->login($this->email, $this->password);

        $this->reset('email','password');
        $this->dispatch('close-login');
    }

    function logout(){
        $this->user_form->logout();
    }
}
