<?php

namespace App\Livewire\Forms;

use App\Models\Article;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class articleForm extends Form
{
    public Article $article;

    #[Rule('required')]
    public $designation;
    public $image;
    public $reference;
    public $description;
    public $quantity;
    public $quantity_min;
    public $priority_id;
    public $brand_id;
    public $provider_id;
    public $price;


    function store(){
        $this->article->create($this->all());
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
