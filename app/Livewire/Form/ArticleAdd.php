<?php

namespace App\Livewire\Form;

use App\Livewire\Forms\ArticleForm;
use App\Models\Article;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class ArticleAdd extends Component
{
    use WithFileUploads;

    public ArticleForm $article_form;

    public function render(){
        return view('livewire.form.article-add',[
        ]);
    }

    function store(){
        $this->validate();
        $this->article_form->store();


        $this->dispatch('close-addArticle');
    }
}
