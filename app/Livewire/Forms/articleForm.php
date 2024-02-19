<?php

namespace App\Livewire\Forms;

use App\Models\Article;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ArticleForm extends Form
{
    public Article $article;

    #[Validate('required')]
    public $designation;
    public $image;
    public $reference;
    public $description;
    #[Validate('numeric')]
    public $quantity = 0;
    #[Validate('numeric')]
    public $quantity_min = 0;
    #[Validate('numeric')]
    public $priority_id = 0;
    #[Validate('numeric')]
    public $brand_id = 0;
    #[Validate('numeric')]
    public $provider_id = 0;
    #[Validate('numeric')]
    public $price = 0;


    function store(){
        $this->validate();
        $article = $this->article->create($this->all());


    }

    function set($model_id){
        $this->article = Article::find($model_id);
    }

    function update(){
        $this->article->update($this->all());
    }

    function delete(){
        $this->article->delete();
    }
}
