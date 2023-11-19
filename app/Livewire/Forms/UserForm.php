<?php

namespace App\Livewire\Forms;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
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
        $this->firstname = ucfirst($this->firstname);
        $this->lastname = ucfirst($this->lastname);
        User::create($this->all());
    }

    function login($email, $password) {
        $credentials = array(
            'email' => $email,
            'password' => $password,
        );

        if (Auth::attempt($credentials)) {
            return true;
        }else {
            return false;
        }
    }

    function logout(){
        Auth::logout();
        return redirect()->intended('/');
    }

    function updateAvatar($avatar) {
        $user = auth()->user();

        $dir = "User/$user->id/avatar";
        Storage::disk('public')->deleteDirectory($dir);
        $name = $avatar->getClientOriginalName();
        $avatar->storeAs("public/$dir", $name);

        $user->avatar = "storage/$dir/$name";
        $user->save();
    }

}
