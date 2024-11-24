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
        $this->validate();
        $this->fix();
        if ($this->projet_id) {
            $this->client_id = Projet::find($this->projet_id)->id;
        }
        $contact = Contact::create($this->all());

        if ($this->avatar) {
            $dir = "erp/contacts/$contact->id/avatar";
            // if ($delete) {
            //     Storage::disk('public')->deleteDirectory($dir);
            // }
            $name = $this->avatar->getClientOriginalName();
            $this->avatar->storeAs("public/$dir", $name);

            $contact->avatar = "storage/$dir/$name";
            $contact->save();
        }


        $this->reset('firstname', 'lastname', 'fonction', 'avatar');
    }

    function set($model_id){
        $this->contact = Contact::find($model_id);
        $this->firstname = $this->contact->firstname;
        $this->lastname = $this->contact->lastname;
        $this->fonction = $this->contact->fonction;
        $this->avatar = $this->contact->avatar;
        $this->projet_id = $this->contact->projet_id;
        $this->client_id = $this->contact->client_id;
    }

    function update(){
        $this->validate();
        $this->contact->update($this->all());
    }

    function delete($model_id){
        $this->contact = Contact::find($model_id);
        $this->contact->delete($model_id);
    }
}
