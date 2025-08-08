<?php

namespace App\Livewire\Forms;

use App\Models\WebpageCategory;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class WebpageCategoryForm extends Form
{
    public WebpageCategory $webpageCategory;

    #[Rule('required')]
    public $name;
    public $description;

    function fix(){
        $this->name = ucfirst($this->name);
    }


    function store(){
        $this->validate();
        $this->fix();
        WebpageCategory::create($this->all());
    }

    function set($model_id){
        $this->webpageCategory = WebpageCategory::find($model_id);
        $this->name = $this->webpageCategory->name;
        $this->description = $this->webpageCategory->description;
    }

    function update(){
        $this->validate();
        $this->webpageCategory->update($this->all());
    }

    function delete($model_id){
        $this->webpageCategory = WebpageCategory::find($model_id);
        $this->webpageCategory->delete();
    }
}
