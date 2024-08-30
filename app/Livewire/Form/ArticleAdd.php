<?php

namespace App\Livewire\Form;

use App\Livewire\Forms\ArticleForm;
use App\Livewire\Forms\ItemForm;
use App\Models\Brand;
use App\Models\Provider;
use Livewire\Component;
use Livewire\WithFileUploads;

class ArticleAdd extends Component
{
    use WithFileUploads;

    public ItemForm $article_form;
    // public ArticleForm $article_form;

    public function render(){
        return view('livewire.form.article-add',[
            'providers' => Provider::all(),
            'brands' => Brand::all(),
        ]);
    }

    function mount(){

        // dump($this->article_form);
        // dump($this->article_form);
        // $this->article_form->quantity = 2;
        // $this->article_form->quantity_min = 2;
        // $this->article_form->priority_id = 2;
        // $this->article_form->price = 0;
        // $this->dispatch('open-addArticle');
    }

    function add(){
        $this->dispatch('open-addArticle');
    }

    function store(){
        $this->article_form->store();

        $this->dispatch('close-addArticle');
        $this->dispatch('get-articles');
    }

    function uppercase(){
        $this->article_form->reference = ucfirst($this->article_form->reference);
    }
}
