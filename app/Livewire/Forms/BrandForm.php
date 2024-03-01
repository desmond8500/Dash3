<?php

namespace App\Livewire\Forms;

use App\Models\ArticleBrand;
use App\Models\Brand;
use Livewire\Attributes\Validate;
use Livewire\Form;

class BrandForm extends Form
{
    public Brand $brand;

    #[Validate('required')]
    public $name;
    public $description;
    public $logo;

    function store(){
        $this->validate();
        Brand::create($this->all());
    }

    function set($brand_id){
        $this->brand = Brand::find($brand_id);
        $this->name = $this->brand->name;
        $this->description = $this->brand->description;
        $this->logo = $this->brand->logo;
    }

    function update(){
        $this->brand->update($this->only(
            'name',
            'description'
        ));
    }

    function delete(){
        $this->brand->delete();
    }
}
