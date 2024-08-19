<?php

namespace App\Livewire\Form;

use App\Livewire\Forms\ArticleForm;
use App\Models\Article;
use App\Models\Brand;
use App\Models\Provider;
use Livewire\Component;
use Livewire\WithFileUploads;

class ArticleAdd extends Component
{
    use WithFileUploads;

    public ArticleForm $article_form;

    public function render(){
        return view('livewire.form.article-add',[
            'providers' => Provider::all(),
            'brands' => Brand::all(),
        ]);
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
