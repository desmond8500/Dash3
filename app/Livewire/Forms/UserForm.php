<?php

namespace App\Livewire\Forms;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Rule;
use Livewire\Form;

class UserForm extends Form
{
    #[Rule('required', message: 'Le prénom est requis')]
    public $firstname;
    #[Rule('required', message: 'Le nom est requis')]
    public $lastname;
    #[Rule('required|email|unique:App\Models\User,email')]
    public $email;
    #[Rule('required')]
    public $password;
    #[Rule('required|same:password')]
    public $password_confirmation;
    public $function;
    public $avatar;

    public User $user;

    function store() {
        $this->validate();
        $this->firstname = ucfirst($this->firstname);
        $this->lastname = ucfirst($this->lastname);
        User::create($this->all());

    }

    function set() {
        $this->user = User::find(auth()->user()->id);
        $this->firstname = auth()->user()->firstname;
        $this->lastname = auth()->user()->lastname;
        $this->function = auth()->user()->function;
        $this->avatar = auth()->user()->avatar;
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

    function update(){
        $this->user->update($this->only('firstname', 'lastname', 'function'));
    }

    function logout(){
        Auth::logout();
        return redirect()->intended('/');
    }

    function updateAvatar($avatar) {
        $user = auth()->user();

        $dir = "user/$user->id/avatar";
        Storage::disk('public')->deleteDirectory($dir);
        $name = $avatar->getClientOriginalName();
        $avatar->storeAs("public/$dir", $name);

        $user->avatar = "storage/$dir/$name";
        $user->save();
    }

    function update_password(){
        $this->validate();
        $this->user->password = Hash::make($this->password);
        $this->user->update($this->all());
    }

}
