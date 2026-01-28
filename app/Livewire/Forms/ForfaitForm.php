<?php

namespace App\Livewire\Forms;

use App\Models\Forfait;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ForfaitForm extends Form
{
    public Forfait $forfait;

    #[Rule('required')]
    public $client_id;
    #[Rule('required')]
    public $description;
    #[Rule('required')]
    public $designation;
    #[Rule('required|integer|min:0')]
    public $price;

    function fix(){
        $this->description = ucfirst($this->description);
        $this->designation = ucfirst($this->designation);
    }

    function store(){
        $this->validate();
        Forfait::create($this->all());
    }

    function set($model_id){
        $this->forfait = Forfait::find($model_id);
        $this->client_id = $this->forfait->client_id;
        $this->description = $this->forfait->description;
        $this->designation = $this->forfait->designation;
        $this->price = $this->forfait->price;
    }

    function update(){
        $this->validate();
        $this->forfait->update($this->all());
    }

    function delete($model_id){
        $this->forfait = Forfait::find($model_id);
        $this->forfait->delete();
    }
}
