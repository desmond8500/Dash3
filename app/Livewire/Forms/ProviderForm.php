<?php

namespace App\Livewire\Forms;

use App\Http\Controllers\ImageController;
use App\Models\Provider;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ProviderForm extends Form
{
    public Provider $provider;

    #[Rule('required')]
    public $name;
    public $logo;
    public $address;
    public $description;
    #[Rule('email|nullable')]
    public $email;
    #[Rule('number|nullable')]
    public $phone;
    #[Rule('url|nullable')]
    public $website;

    function fix(){
        $this->name = ucfirst($this->name);
    }

    function store(){
        $this->validate();
        $provider = Provider::create($this->all());

        if ($this->logo) {
            $provider->logo = ImageController::store_logo("stock/providers/$provider->id/logo",$this->logo);
            $provider->save();
        }
    }

    function set($model_id){
        $this->provider = Provider::find($model_id);
        $this->name = $this->provider->name;
        $this->logo = $this->provider->logo;
        $this->address = $this->provider->address;
        $this->description = $this->provider->description;
        $this->email = $this->provider->email;
        $this->phone = $this->provider->phone;
        $this->website = $this->provider->website;
    }

    function update(){
        $this->validate();
        $this->provider->update($this->all());
    }

    function delete($model_id){
        $this->provider = Provider::find($model_id);
        $this->provider->delete();
    }
}
