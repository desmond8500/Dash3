<?php

namespace App\Livewire\Forms;

use App\Models\QuantitatifRow;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class QuantitatifRowForm extends Form
{
    public QuantitatifRow $row;

    #[Rule('required')]
    public $quantitatif_id;
    public $article_id;
    public $quantite;
    public $description;

    function store(){
        $this->validate();
        QuantitatifRow::create($this->all());
    }

    function set($model_id){
        $this->row= QuantitatifRow::find($model_id);
        $this->quantitatif_id = $this->row->quantitatif_id;
        $this->article_id = $this->row->article_id;
        $this->quantite = $this->row->quantite;
        $this->description = $this->row->description;
    }

    function update(){
        $this->validate();
        $this->row->update($this->all());
    }

    function delete(){
        $this->row->delete();
    }
}
