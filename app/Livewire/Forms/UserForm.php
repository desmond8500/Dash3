<?php

namespace App\Livewire\Forms;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Livewire\Attributes\Rule;
use Livewire\Form;

class UserForm extends Form
{
    #[Rule('required')]
    public $firstname;
    #[Rule('required')]
    public $lastname;
    #[Rule('required|email|unique:App\Models\User,email')]
    public $email;
    #[Rule('required')]
    public $password;
    #[Rule('required|same:user.password')]
    public $password_confirmation;

    function store() {
        User::create($this->all());
    }

    function login($email, $password) {
        $credentials = array(
            'email' => $email,
            'password' => $password,
        );

        if (Auth::attempt($credentials)) {
            $user = User::where('email',$email)->get();
            // Auth::login($user);
        }
        return redirect()->intended('/');
    }

    function logout(){
        Auth::logout();
        return redirect()->intended('/');
    }

}
