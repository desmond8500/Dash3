<?php

namespace App\Livewire;

use App\Livewire\Forms\UserForm;
use Livewire\Attributes\Layout;
use Livewire\Component;

class LoginPage extends Component
{
    public function render()
    {
        return view('livewire.login-page');
    }

    public UserForm $user_form;
    public $formtype = true;

    public $email;
    public $password;
    public $errorMessage;

    #[Layout('components.layouts.login')]
    function login()
    {
        $this->validate([
            'email' => 'required|email|exists:App\Models\User,email',
            'password' => 'required'
        ]);

        $login = $this->user_form->login($this->email, $this->password);
        if ($login) {
            $this->reset('email', 'password', 'errorMessage');
            $this->dispatch('close-login');
            return redirect()->intended('/');
        } else {
            $this->errorMessage = 'Les identifiants sont incorrects';
        }
    }

}
