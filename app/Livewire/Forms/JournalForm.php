<?php

namespace App\Livewire\Forms;

use App\Models\Journal;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class JournalForm extends Form
{
    public Journal $journal;

    #[Rule('required')]
    public $user_id;
    public $client_id;
    public $projet_id;
    public $devis_id;
    #[Rule('required')]
    public $title;
    #[Rule('required')]
    public $date;
    public $description;

    function store(){
        $this->user_id = auth()->user()->id;
        $this->validate();
        Journal::create($this->all());
    }

    function set($model_id){
        $this->journal = Journal::find($model_id);

        $this->user_id = $this->journal->user_id;
        $this->client_id = $this->journal->client_id;
        $this->projet_id = $this->journal->projet_id;
        $this->devis_id = $this->journal->devis_id;
        $this->title = $this->journal->title;
        $this->date = $this->journal->date;
        $this->description = $this->journal->description;
    }

    function update(){
        $this->journal->update($this->all());
    }

    function delete(){
        $this->journal->delete();
    }
}
