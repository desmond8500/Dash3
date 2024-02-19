<?php

namespace App\Livewire\Form;

use App\Livewire\Forms\BrandForm;
use Livewire\Component;

class BrandAdd extends Component
{
    public BrandForm $brand_form;

    public function render(){
        return view('livewire.form.brand-add');
    }

    function store(){
        $this->brand_form->store();
    }
}
