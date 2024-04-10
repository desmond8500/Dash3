<?php

namespace App\Livewire\Form;

use App\Livewire\Forms\SystemeForm;
use Livewire\Component;

class SystemeAdd extends Component
{
    public function render()
    {
        return view('livewire.form.systeme-add');
    }

    public SystemeForm $systeme_form;

    function store()
    {
        $this->systeme_form->store();
        $this->dispatch('close-addSysteme');
    }
}
