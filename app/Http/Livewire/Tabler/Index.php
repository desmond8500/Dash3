<?php

namespace App\Http\Livewire\Tabler;

use App\Models\User;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.tabler.index',[

        ])->extends('0 tabler.layout')->section('content');
    }
}
