<?php

namespace App\Livewire\Forms;

use App\Models\Phone;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class PhoneForm extends Form
{
    public Phone $phonem;

    #[Rule('required')]
    public $phone;
    public $client_id;
    public $contact_id;
    public $team_id;
    public $provider_id;

    function store(){
        $this->validate();
        Phone::create($this->all());
    }

    function set($model_id){
        $this->phonem = Phone::find($model_id);
        $this->client_id = $this->phonem->client_id;
        $this->contact_id = $this->phonem->contact_id;
        $this->team_id = $this->phonem->team_id;
        $this->provider_id = $this->phonem->provider_id;
        $this->phone = $this->phonem->phone;
    }

    function update(){
        $this->validate();
        $this->phonem->update($this->all());
    }

    function delete($model_id){
        $this->phonem = Phone::find($model_id);
        $this->phonem->delete();
    }
}
