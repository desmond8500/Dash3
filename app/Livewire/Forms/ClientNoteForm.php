<?php

namespace App\Livewire\Forms;

use App\Models\ClientNote;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ClientNoteForm extends Form
{
    public ClientNote $client_note;

    #[Rule('required')]
    public $client_id;
    public $description;
    public $note;

    function fix(){
        $this->description = ucfirst($this->description);
    }


    function store(){
        $this->validate();
        ClientNote::create($this->all());
    }

    function set($model_id){
        $this->client_note = ClientNote::find($model_id);
        $this->client_id = $this->$this->client_note->client_id;
        $this->description = $this->$this->client_note->description;
        $this->note = $this->$this->client_note->note;
    }

    function update(){
        $this->validate();
        $this->client_note->update($this->all());
    }

    function delete(){
        $this->client_note->delete();
    }
}
