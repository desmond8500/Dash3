<?php

namespace App\Livewire;

use App\Exports\ClientsExport;
use App\Models\Client;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class TestPage extends Component
{
    use WithFileUploads;
    public $file;
    public $collection = [1,2,3,4,5,6,7,8];
    public $tabs, $selected_tab = 0;
    public function mount(){
    $this->tabs = (object) array(
        (object) array('id' => 'tabs-home-ex2', 'icon' => 'home', 'name' => 'Home', 'class'=>''),
        (object) array('id' => 'tabs-profile-ex2', 'icon' => 'profile', 'name' => 'Profile', 'class'=>''),
        (object) array('id' => 'tabs-settings-ex2', 'icon' => 'settings', 'name' => 'Settings', 'class'=> 'ms-auto'),
    );
    }

    function select($id){
        $this->selected_tab = $id;
    }

    public $genre = ['Homme', 'femme'];


    public function render()
    {
        return view('livewire.test-page',[
            'clients' => Client::all(),
        ]);
    }

    function download(){
        return Excel::download(new ClientsExport, 'clients.xlsx');
    }


    function store(){

    }


}
