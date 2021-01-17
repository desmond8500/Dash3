<?php

namespace App\Http\Livewire\Tabler\Admin;

use App\Models\User;
use Livewire\Component;

class Users extends Component
{

    public function render()
    {
        return view('livewire.tabler.admin.users',[
            "users" => User::all()
        ]);
        // ])->extends('0 tabler.layout')->section('content');
    }

    public $user_name, $user_email, $user_role, $user_statut;

    public function edit_user($id){
        $user = User::find($id);
        $this->user_name = $user->name;
        $this->user_email = $user->email;
        $this->user_role = $user->role;
        $this->user_statut = $user->statut;
    }

    public function update_user($id){
        $user = User::find($id);
        $user->name = $this->user_name ;
        $user->email = $this->user_email ;
        $user->role = $this->user_role ;
        $user->statut = $this->user_statut ;
        $user->save();
    }
}
