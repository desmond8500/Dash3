<?php

namespace App\Livewire\Form;

use App\Livewire\Forms\ContactForm;
use Livewire\Component;

class ContactAdd extends Component
{
    public ContactForm $contact_form;

    public $projet_id;

    function mount($projet_id = 0)
    {
        $this->projet_id = $projet_id;
    }

    public function render()
    {
        return view('livewire.form.contact-add');
    }

    function store(){
        $this->contact_form->store();
        $this->dispatch('close-addContact');
    }
}
