<?php

namespace App\Livewire\Forms;

use App\Models\Client;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Rule;
use Livewire\Form;

class clientForm extends Form
{
    #[Rule('required')]
    public $name;
    public $description;
    public $address;
    public $avatar;
    public $status = 1;
    public $type = 'Entreprise';

    function store()
    {
        $this->validate();
        $this->name = ucfirst($this->name);
        $this->description = ucfirst($this->description);
        $client = Client::create($this->all());

        if ($this->avatar) {
            $this->storeAvatar($client, $this->avatar);
        }
        $this->reset();
    }

    function storeAvatar($client, $avatar){
        $dir = "Erp/Client/$client->id/avatar";
        Storage::disk('public')->deleteDirectory($dir);
        $name = $avatar->getClientOriginalName();
        $avatar->storeAs("public/$dir", $name);

        $client->avatar = "storage/$dir/$name";
        $client->save();
    }

    function set($client){
        $client = (object) $client;

        $this->name = $client->name;
        $this->description = $client->description;
        $this->type = $client->type;
        $this->status = $client->status;
        $this->avatar = $client->avatar;
        $this->address = $client->address;
    }

    function update($selected) {
        $client = Client::find($selected["id"]);
        $client->name = ucfirst($this->name);
        $client->type =  $this->type;
        $client->description = ucfirst($this->description);
        $client->status =  $this->status;
        $client->avatar =  $this->avatar;
        $client->address =  $this->address;

        if ($this->avatar) {
            $this->storeAvatar($client, $this->avatar);
        }

        $client->save();
        $this->reset();
    }

    function delete($id){
        $client = Client::find($id);
        $client->delete();
    }
}
