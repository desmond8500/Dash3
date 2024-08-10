<?php

namespace App\Livewire\Forms;

use App\Models\Contact;
use App\Models\Projet;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ContactForm extends Form
{
    public Contact $contact;

    public $projet_id;
    public $client_id;
    #[Rule('required')]
    public $firstname;
    #[Rule('required')]
    public $lastname;
    public $fonction;
    public $avatar;

    function fix(){
        $this->firstname = ucfirst($this->firstname);
        $this->lastname = ucfirst($this->lastname);
        $this->fonction = ucfirst($this->fonction);
        $this->avatar = ucfirst($this->avatar);
    }

    function store(){
        // $this->validate();
        if ($this->projet_id) {
            $this->client_id = Projet::find($this->projet_id)->id;
        }


        Contact::create($this->all());
    }

    function set($model_id){
        $this->contact = Contact::find($model_id);
        $this->firstname = $this->contact->firstname;
        $this->lastname = $this->contact->lastname;
        $this->fonction = $this->contact->fonction;
        $this->avatar = $this->contact->avatar;
    }

    function update(){
        $this->validate();
        $this->contact->update($this->all());
    }

    function delete(){
        $this->contact->delete();
    }
}
