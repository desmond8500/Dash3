<?php

namespace App\Http\Livewire\Tabler\Admin;

use App\Models\User;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.tabler.admin.index',[
            "users" => User::count()
        ])->extends('0 tabler.layout')->section('content');
    }

    public $page = "index";

    public function get_page(){

    }
}
