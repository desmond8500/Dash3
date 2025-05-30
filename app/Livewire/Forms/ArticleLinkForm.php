<?php

namespace App\Livewire\Forms;

use App\Models\ArticleLink;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ArticleLinkForm extends Form
{
    public ArticleLink $lien;

    #[Rule('required')]
    public $article_id;
    #[Rule('required')]
    public $link;
    public $name;

    function fix(){
        $this->name = ucfirst($this->name);
    }

    function store(){
        $this->validate();
        ArticleLink::create($this->all());
        $this->reset(['article_id', 'link', 'name']);
    }

    function set($model_id){
        $this->lien = ArticleLink::find($model_id);
        $this->article_id = $this->lien->article_id;
        $this->name = $this->lien->name;
        $this->link = $this->lien->link;
    }

    function update(){
        $this->validate();
        $this->lien->update($this->all());
    }

    function delete(){
        $this->lien->delete();
    }
}
