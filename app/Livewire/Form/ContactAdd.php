<?php

namespace App\Livewire\Form;

use App\Livewire\Forms\ContactForm;
use Livewire\Component;

class ContactAdd extends Component
{
    public ContactForm $contact_form;

    public $client_id;
    public $projet_id;

    function mount($projet_id = 0, $client_id = 0)
    {
        if ($projet_id) {
            $this->contact_form->projet_id = $projet_id;
        }

        if ($client_id) {
            $this->contact_form->client_id = $client_id;
        }
    }

    public function render()
    {
        return view('livewire.form.contact-add');
    }

    function store(){
        $this->contact_form->store();
        $this->dispatch('close-addContact');
        $this->dispatch('get-contacts');
    }
}
