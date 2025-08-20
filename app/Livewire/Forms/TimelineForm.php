<?php

namespace App\Livewire\Forms;

use App\Models\Timeline;
use Livewire\Attributes\Rule;
use Livewire\Form;

class TimelineForm extends Form
{
    public Timeline $timeline;

    #[Rule('required')]
    public $user_id;
    #[Rule('required')]
    public $title;
    public $description;
    public $client_id;
    public $projet_id;
    public $invoice_id;
    public $task_id;
    public $systeme_id;
    public $article_id;
    public $provider_id;
    public $brand_id;
    public $achat_id;
    public $building_id;
    public $stage_id;
    public $room_id;
    public $journal_id;

    function fix(){
        $this->title = ucfirst($this->title);
    }


    function store(){
        $this->validate();
        $this->fix();
        Timeline::create($this->all());
    }

    function set($model_id){
        $this->timeline = Timeline::find($model_id);
        $this->user_id = $this->timeline->user_id;
        $this->title = $this->timeline->title;
        $this->description = $this->timeline->description;
        $this->client_id = $this->timeline->client_id;
        $this->projet_id = $this->timeline->projet_id;
        $this->invoice_id = $this->timeline->invoice_id;
        $this->task_id = $this->timeline->task_id;
        $this->systeme_id = $this->timeline->systeme_id;
        $this->article_id = $this->timeline->article_id;
        $this->provider_id = $this->timeline->provider_id;
        $this->brand_id = $this->timeline->brand_id;
        $this->achat_id = $this->timeline->achat_id;
        $this->building_id = $this->timeline->building_id;
        $this->stage_id = $this->timeline->stage_id;
        $this->room_id = $this->timeline->room_id;
        $this->journal_id = $this->timeline->journal_id;
    }

    function update(){
        $this->validate();
        $this->timeline->update($this->all());
    }

    function delete($model_id){
        $this->timeline = Timeline::find($model_id);
        $this->timeline->delete();
    }

    // Invoice
    function add_invoice($projet_id, $invoice_id){
        Timeline::create([
            'user_id'=> auth()->user()->id,
            'title' => "Ajout d'un devis",
            'invoice_id' => $invoice_id,
            'projet_id' => $projet_id,

        ]);
    }
}
