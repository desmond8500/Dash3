<?php

namespace App\Livewire\Form;

use App\Livewire\Forms\ProviderForm;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProviderAdd extends Component
{
    use WithFileUploads;

    public function render()
    {
        return view('livewire.form.provider-add');
    }

    public $provider;
    public ProviderForm $provider_form;

    function store(){
        $this->provider_form->store();
        $this->dispatch('close-addProvider');
    }
}
