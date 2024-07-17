<?php

namespace App\Livewire\Form;

use App\Livewire\Forms\ArticleForm;
use App\Models\Brand;
use App\Models\Provider;
use Livewire\Component;
use Livewire\WithFileUploads;

class ArticleAdd extends Component
{
    use WithFileUploads;

    public ArticleForm $article_form;

    function mount(){
        $this->article_form->quantity = 0;
        $this->article_form->quantity_min = 0;
        $this->article_form->price = 0;
    }

    public function render(){
        return view('livewire.form.article-add',[
            'providers' => Provider::all(),
            'brands' => Brand::all(),
        ]);
    }

    function store(){
        $this->validate();
        $this->article_form->store();

        $this->dispatch('close-addArticle');
        $this->dispatch('get-articles');
    }
}
