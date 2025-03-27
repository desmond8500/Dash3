<?php

namespace App\Livewire\Stock;

use App\Livewire\Forms\ArticleLinkForm;
use App\Models\ArticleLink;
use Livewire\Attributes\On;
use Livewire\Component;

class ArticleLinks extends Component
{
    public $article_id;
    public ArticleLinkForm $article_link_form;

    function mount($article_id){
        $this->article_id = $article_id;
    }

    #[On('get-article-links')]
    public function render()
    {
        return view('livewire.stock.article-links',[
            'links' => ArticleLink::where('article_id', $this->article_id)->get()
        ]);
    }

    function edit($id)
    {
        $this->article_link_form->set($id);
        $this->dispatch('open-editArticleLink');
    }

    function update()
    {
        $this->article_link_form->update();
        $this->dispatch('close-editArticleLink');
    }

    function delete()
    {
        $this->article_link_form->delete();
        $this->dispatch('close-editArticleLink');
    }

    function set_name($name)
    {
        $this->article_link_form->name = $name;
    }
}
