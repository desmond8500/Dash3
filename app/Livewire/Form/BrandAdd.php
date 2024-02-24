<?php

namespace App\Livewire\Form;

use App\Livewire\Forms\BrandForm;
use Livewire\Component;
use Livewire\WithFileUploads;

class BrandAdd extends Component
{
    use WithFileUploads;

    public BrandForm $brand_form;

    public function render(){
        return view('livewire.form.brand-add');
    }

    function store(){
        $this->brand_form->store();
        $this->dispatch('close-addBrand');
        $this->dispatch('get-brands');
    }
}
