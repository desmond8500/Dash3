<?php

namespace App\Livewire\Forms;

use App\Models\BrandLink;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class BrandLinkForm extends Form
{
    public BrandLink $lien;

    #[Rule('required')]
    public $brand_id;
    #[Rule('required')]
    public $name;
    public $link;
    public $folder;
    public $description;

    function fix(){
        $this->name = ucfirst($this->name);
    }

    function store(){
        // $this->validate();
        $this->fix();
        BrandLink::create($this->all());
    }

    function set($model_id){
        $this->lien = BrandLink::find($model_id);
        $this->brand_id = $this->lien->brand_id;
        $this->name = $this->lien->name;
        $this->link = $this->lien->link;
        $this->description = $this->lien->description;
    }

    function update(){
        $this->validate();
        $this->lien->update($this->all());
    }

    function delete($id){
        $this->lien = BrandLink::find($id);
        $this->lien->delete();
    }
}
