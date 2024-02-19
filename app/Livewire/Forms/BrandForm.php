<?php

namespace App\Livewire\Forms;

use App\Models\ArticleBrand;
use Livewire\Attributes\Validate;
use Livewire\Form;

class BrandForm extends Form
{
    public ArticleBrand $brand;

    #[Validate('required')]
    public $name;
    public $description;
    public $logo;

    function store(){
        $this->validate();
        $this->brand->create($this->all());
    }

    function set($brand_id){
        $this->brand = ArticleBrand::find($brand_id);
    }

    function update(){
        $this->brand->update($this->all());
    }

    function delete(){
        $this->brand->delete();
    }
}
