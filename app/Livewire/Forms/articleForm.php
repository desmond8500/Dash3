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
    #[Validate('required')]
    public $reference;
    #[Validate('numeric')]
    public $quantity_min = 0;
    #[Validate('numeric')]
    public $priority_id = 1;
    #[Validate('numeric')]
    public $quantity = 1;
    #[Validate('numeric')]
    public $price = 0;

    public $description;

    public $brand_id;

    public $provider_id;

    public $image;

    function store(){
        $this->validate();
       Article::create($this->all());
        // $article = Article::create($this->only(
        //     'designation',
        //     'reference',
        //     'description',
        //     'quantity',
        //     'quantity_min',
        //     'priority_id',
        //     'brand_id',
        //     'provider_id',
        //     'price',
        // ));

        // if ($this->image) {
        //     $images = $this->image;
        //     $dir = "stock/articles/$article->id/images";
        //     foreach ($images as $key => $image) {
        //         $name = $image->getClientOriginalName();
        //         $image->storeAS("public/$dir", $name);
        //     }

        //     $article->image = "storage/$dir/$name";
        //     // $article->image = "stockage/$dir/$name";
        //     $article->save();
        // }
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
        $article = $this->article->update($this->only(
            'designation',
            'reference',
            'description',
            'quantity',
            'quantity_min',
            'priority_id',
            'brand_id',
            'provider_id',
            'price',
        ));

        if ($this->image && is_array($this->image)) {
            $this->article = Article::find($this->article->id);
            $images = $this->image;
            $dir = "stock/articles/".$this->article->id."/images";
            foreach ($images as $key => $image) {
                $name = $image->getClientOriginalName();
                $image->storeAS("public/$dir", $name);
            }

            $this->article->image = "$dir/$name";
            // $article->image = "stockage/$dir/$name";
            $this->article->save();
        }
        return $article;
    }

    function delete($id){
        $article = Article::find($id);
        $article->delete();
    }
}
