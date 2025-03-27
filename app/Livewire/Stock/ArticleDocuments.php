<?php

namespace App\Livewire\Stock;

use App\Livewire\Forms\ArticleDocumentForm;
use App\Livewire\Forms\ArticleLinkForm;
use App\Models\ArticleDocument;
use Livewire\Attributes\On;
use Livewire\Component;

class ArticleDocuments extends Component
{
    public $article_id1;
    public ArticleDocumentForm $article_document_form;

    function mount($article_id)
    {
        $this->article_id1 = $article_id;
    }

    #[On('get-article-documents')]
    public function render()
    {
        return view('livewire.stock.article-documents', [
            'documents' => ArticleDocument::where('article_id', $this->article_id1)->get(),
        ]);
    }

    function edit($id)
    {
        $this->article_document_form->set($id);
        $this->dispatch('open-editArticleDocument');
    }

    function update()
    {
        $this->article_document_form->update();
        $this->dispatch('close-editArticleDocument');
    }

    function delete()
    {
        $this->article_document_form->delete();
        $this->dispatch('close-editArticleDocument');
    }
}
