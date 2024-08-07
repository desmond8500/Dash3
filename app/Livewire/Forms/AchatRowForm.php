<?php

namespace App\Livewire\Forms;

use App\Models\AchatRow;
use App\Models\Article;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class AchatRowForm extends Form
{
    public AchatRow $row;

    #[Rule('required')]
    public $achat_id;
    public $designation;
    public $reference;
    public $quantite=1;
    public $prix;
    public $tva = 0;

    function store(){
        AchatRow::create($this->all());
    }

    function add_article($article_id, $achat_id){
        $article = Article::find($article_id);
        $this->achat_id = $achat_id;
        $this->designation = $article->designation;
        $this->reference = $article->reference;
        $this->prix = $article->price;

        $this->store();
    }

    function set($model_id){
        $this->row = AchatRow::find($model_id);

        $this->achat_id = $this->row->achat_id;
        $this->designation = $this->row->designation;
        $this->reference = $this->row->reference;
        $this->quantite = $this->row->quantite;
        $this->prix = $this->row->prix;
        $this->tva = $this->row->tva;
    }

    function update(){
        $this->validate();
        if ($this->tva) {
            $this->tva = 0.18;
        }
        $this->row->update($this->all());
    }

    function delete($model_id){
        $this->row = AchatRow::find($model_id);
        $this->row->delete();
    }
}
