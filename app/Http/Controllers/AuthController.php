<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public $firstname;
    public $lastname;
    public $email;
    public $password;
    public $cpassxord;

    static function login() {

    }

    static function register($firstname,$lastname,$email,$password)
    {
        User::firstOrCreate([
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'password' => Hash::make($password),
        ]);
    }
}
