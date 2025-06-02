<?php

namespace App\Livewire\Forms;

use App\Models\Client;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Rule;
use Livewire\Form;

class clientForm extends Form
{
    public Client $client;

    #[Rule('required')]
    public $name;
    public $description;
    public $address;
    public $avatar;
    public $status = 1;
    public $type = 'Entreprise';
    public $favorite = 0;

    function reset_form(){
        $this->reset('name','description','address','avatar');
    }

    function store()
    {
        $this->validate();
        $this->name = ucfirst($this->name);
        $this->description = ucfirst($this->description);
        $client = Client::create($this->all());

        if ($this->avatar) {
            $this->storeAvatar($client, $this->avatar);
        }
        $this->reset_form();
    }

    function storeAvatar($client, $avatar, $delete = false){
        if (!is_string($this->avatar)) {
            $dir = "erp/clients/$client->id/avatar";
            if ($delete) {
                Storage::disk('public')->deleteDirectory($dir);
            }
            $name = $avatar->getClientOriginalName();
            $avatar->storeAs("public/$dir", $name);

            $client->avatar = "storage/$dir/$name";
            $client->save();
        }
    }

    function set($client_id){
        $this->client = Client::find($client_id);

        $this->name = $this->client->name;
        $this->description = $this->client->description;
        $this->type = $this->client->type;
        $this->status = $this->client->status;
        $this->avatar = $this->client->avatar;
        $this->address = $this->client->address;
        $this->favorite = $this->client->favorite;
    }

    function update($selected) {
        $client = Client::find($selected["id"] ?? $this->client->id);
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
        $this->reset_form();
    }

    function delete($id){
        $client = Client::find($id);
        $client->delete();
    }

    function favorite($id){
        $this->set($id);
        if ($this->favorite) {
            $this->favorite = 0;
        } else {
            $this->favorite = 1;
        }
        $this->client->update($this->only('favorite'));
    }
}
