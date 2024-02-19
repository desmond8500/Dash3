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
