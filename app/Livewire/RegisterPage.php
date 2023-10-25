<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Livewire\Component;

class RegisterPage extends Component
{
    public function render()
    {
        return view('livewire.register-page');
    }

    public $firstname, $lastname, $email, $password;

    function rules(){
        return [
            'email' => ValidationRule::unique('users'),
        ];
    }

    function register() {

        User::create([
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'password' => $this->password,
        ]);

    }
}
