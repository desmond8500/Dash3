<?php

namespace App\Livewire;

use App\Http\Controllers\DashController;
use App\Models\Client;
use App\Models\User;
use Livewire\Component;

class IndexPage extends Component
{
    public function render()
    {
        return view('livewire.index-page',[
            'init' => User::count(),
            'resumes' => $this->getResume(),
        ]);
    }
    // Init
    function initServer(){
        if (!User::count()) {
            DashController::initUser();
            DashController::initRoles();
        }
    }

    // Resume

    function getResume(){
        return (Object) array(
            (Object) array( 'name'=> 'Clients', 'all'=> Client::count(), 'route'=> route('clients'))
        );
    }


}
