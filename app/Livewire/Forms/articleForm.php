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
    #[Validate('required')]
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
        $article = Article::create($this->all());
    }

    function set($model_id){
        $this->article = Article::find($model_id);

        $this->designation  = $this->article->designation;
        $this->image        = $this->article->image;
        $this->reference    = $this->article->reference;
        $this->description  = $this->article->description;
        $this->quantity     = $this->article->quantity;
        $this->quantity_min = $this->article->quantity_min;
        $this->priority_id  = $this->article->priority_id;
        $this->brand_id     = $this->article->brand_id;
        $this->provider_id  = $this->article->provider_id;
        $this->price        = $this->article->price;
    }

    function update(){
        $this->validate();
        $this->article->update();
    }

    function delete(){
        $this->article->delete();
    }
}
