<?php

namespace App\Livewire\Form;

use App\Models\Article;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ArticleAdd extends Component
{
    #[Validate('required')]
    public $designation;
    public $image;
    public $reference;
    public $description;
    #[Validate('numeric')]
    public $quantity=0;
    #[Validate('numeric')]
    public $priority_id = 0;
    #[Validate('numeric')]
    public $brand_id = 0;
    #[Validate('numeric')]
    public $provider_id = 0;
    #[Validate('numeric')]
    public $price = 0;

    public function render(){
        return view('livewire.form.article-add');
    }

    function store(){
        $this->validate();
        Article::firstOrCreate([
            'designation' => $this->designation,
            'reference' => $this->reference,
            'description' => $this->description,
            'quantity' => $this->quantity,
            'priority_id' => $this->priority_id,
            'brand_id' => $this->brand_id,
            'provider_id' => $this->provider_id,
            'price' => $this->price,
        ]);

        $this->dispatch('close-addArticle');
    }
}
