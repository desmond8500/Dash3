<?php

namespace App\Livewire\Forms;

use App\Models\Quantitatif;
use App\Models\QuantitatifRow;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class QuantitatifForm extends Form
{
    public Quantitatif $quantitatif ;

    #[Rule('required')]
    public $buiding_id;
    public $devis_id;
    public $name;

    function fix(){
        $this->name = ucfirst($this->name);
    }

    function store(){
        $this->validate();
        Quantitatif::create($this->all());
    }

    function set($model_id){
        $this->quantitatif = Quantitatif::find($model_id);
        $this->buiding_id = $this->quantitatif->buiding_id;
        $this->devis_id = $this->quantitatif->devis_id;
        $this->name = $this->quantitatif->name;
    }

    function update(){
        $this->validate();
        $this->quantitatif->update($this->all());
    }

    function delete(){
        $this->quantitatif->delete();
    }

    function create_articles($articles, $quantitatif){
        foreach ($articles as $key => $article) {
            QuantitatifRow::create([
                'quantitatif_id' => $quantitatif->id,
                'article_id' => $article->id,
                'quantite' => $article->quantite,
                'description' => $quantitatif->name,
            ]);
        }
    }
}
