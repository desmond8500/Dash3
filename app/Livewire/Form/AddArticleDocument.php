<?php

namespace App\Livewire\Form;

use App\Livewire\Forms\ArticleDocumentForm;
use Livewire\Component;
use Livewire\WithFileUploads;

class AddArticleDocument extends Component
{
    use WithFileUploads;
    public $article_id;
    public ArticleDocumentForm $article_document_form;

    function mount($article_id){
        $this->article_id = $article_id;
        $this->article_document_form->article_id = $article_id;
    }
    public function render()
    {
        return view('livewire.form.add-article-document');
    }

    function store(){
        $this->article_document_form->store();
        $this->dispatch('close-addArticleDocument');
        $this->dispatch('get-article-documents');
    }
}
