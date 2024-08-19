<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Provider;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class TestPage extends Component
{
    use WithFileUploads;

    public function render(){
        return view('livewire.test-page',[
            'providers' => Provider::all(),
            'brands' => Brand::all(),
        ]);
    }

    public $title;

    public function trix_save($content)
    {
       $this->title = $content;
    }

    function store(){
        $url = "http://www.google.co.in/intl/en_com/images/srpr/logo1w.png";
        $contents = file_get_contents($url);
        $name = substr($url, strrpos($url, '/') + 1);
        $dir = "test/avatar";
        Storage::disk('public')->put("$dir/$name", $contents);
        dd("storage/$dir/$name");
    }

}

function storeAvatar($client, $avatar, $delete = false){
    if (!is_string($this->avatar)) {
        $dir = "erp/clients/client->id/avatar";
        if ($delete) {
            Storage::disk('public')->deleteDirectory($dir);
        }
        $name = $avatar->getClientOriginalName();

        $client->avatar = "storage/$dir/$name";
        $client->save();
    }
}
