<?php

namespace App\Livewire\Forms;

use App\Models\ProjetNote;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ProjetNoteForm extends Form
{
    public ProjetNote $note;

    #[Rule('required')]
    public $projet_id;
    #[Rule('required')]
    public $titre;
    public $description;

    function fix(){
        $this->titre = ucfirst($this->titre);
    }

    function store(){
        $this->validate();
        ProjetNote::create($this->all());
    }

    function set($model_id){
        $this->note = ProjetNote::find($model_id);
        $this->projet_id = $this->note->projet_id;
        $this->titre = $this->note->titre;
        $this->description = $this->note->description;
    }

    function update(){
        $this->validate();
        $this->note->update($this->all());
    }

    function delete($id){
        $this->note = ProjetNote::find($id);
        $this->note->delete();
    }
}
