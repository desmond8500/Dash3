<?php

namespace App\Livewire\Layout;

use App\Livewire\Forms\UserForm;
use Livewire\Component;

class Navbar extends Component
{
    public $menu1 = array(
        array('name' => "Clients", "route" => "clients", "icon" => "users", "can"=>"clients"),
        array('name' => "Journaux", "route" => "journaux", "icon" => "article", "can"=> "journaux"),
        array('name' => "Stock", "route" => "stock", "icon" => "packages", "can"=> "stock"),
        array('name' => "Finances", "route" => "finances", "icon" => "coins", "can"=> "finances"),
        array('name' => "Test", "route" => "test", "icon" => "hammer", "can"=> "test"),
        array('name' => "Systemes", "route" => "systemes", "icon" => "hammer", "can"=> "settings"),
        array('name' => "Medias", "icon" => "hammer", "can"=> "medias",
            'submenu' => [
                array('name' => "Images", "route" => "systemes", "icon" => "hammer"),
                array('name' => "Vidéos", "route" => "systemes", "icon" => "hammer"),
            ]
        ),
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
    public $errorMessage;

    function login(){
        $this->validate([
            'email' => 'required|email|exists:App\Models\User,email',
            'password' => 'required'
        ]);

        $login = $this->user_form->login($this->email, $this->password);
        if ($login) {
            $this->reset('email','password', 'errorMessage');
            $this->dispatch('close-login');
            return redirect()->intended('/');
        } else {
           $this->errorMessage ='Les identifiants sont incorrects';
        }

    }

    function logout(){
        $this->user_form->logout();
    }
}
