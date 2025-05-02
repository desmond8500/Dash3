<?php

namespace App\Livewire\Forms;

use App\Models\Pv;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class PvForm extends Form
{
    public Pv $pv;

    #[Rule('required')]
    public $invoice_id;
    public $title;
    public $subtitle;
    public $date;
    public $client;
    public $client_logo;
    public $bct;
    public $bct_logo;
    public $mo;
    public $mo_logo;
    public $me;
    public $me_logo;
    public $projet;
    public $projet_description;


    function fix(){
        // $this->name = ucfirst($this->name);
    }


    function store(){
        $this->validate();
        Pv::create($this->all());
    }

    function set($model_id){
        $this->pv = Pv::find($model_id);
        // $this->name = $this->pv->name;
    }

    function update(){
        $this->validate();
        $this->pv->update($this->all());
    }

    function delete($model_id){
        $this->pv = Pv::find($model_id);
        $this->pv->delete();
    }
}
