<?php

namespace App\Livewire;

use App\Http\Controllers\DashController;
use App\Models\User;
use Livewire\Component;

class IndexPage extends Component
{
    public function render()
    {
        return view('livewire.index-page',[
            'init' => User::count()
        ]);
    }

    function initServer(){
        if (!User::count()) {
            DashController::initUser();
            DashController::initRoles();
        }
    }
}
