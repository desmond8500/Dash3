<?php

namespace App\Livewire\Form;

use App\Livewire\Forms\ArticleLinkForm;
use Livewire\Attributes\On;
use Livewire\Component;

class AddArticleLink extends Component
{
    public $article_id;
    public ArticleLinkForm $article_link_form;

    function mount($article_id){
        $this->article_id = $article_id;
        $this->article_link_form->article_id = $article_id;
    }

    public function render()
    {
        return view('livewire.form.add-article-link');
    }

    function store(){
        $this->article_link_form->store();
        $this->dispatch('close-addArticleLink');
        $this->dispatch('get-article-links');
    }

    function set_name($name){
        $this->article_link_form->name = $name;
    }

}
