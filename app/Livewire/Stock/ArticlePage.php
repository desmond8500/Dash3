<?php

namespace App\Livewire\Stock;

use App\Livewire\Forms\ArticleForm;
use App\Models\Article;
use App\Models\Brand;
use App\Models\Provider;
use Livewire\Component;
use Livewire\WithFileUploads;

class ArticlePage extends Component
{
    // use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';
    public $search ='';
    public $breadcrumbs;
    public $article;
    public ArticleForm $article_form;

    public function mount($article_id){
        $this->article = Article::find($article_id);
        $this->article_form->set($article_id);

        $this->breadcrumbs = array(
            array('name' => 'Stock', 'route' => route('stock')),
            array('name' => 'Articles', 'route' => route('articles')),
            array('name' => 'Article', 'route' => route('article',['article_id'=>$article_id])),
        );
    }

    function ProjetSearch() {
        // return Projet::where('client_id', $this->client_id)->where('name', 'like', '%' . $this->search . '%')->paginate(10);
    }

    public function render()
    {
        return view('livewire.stock.article-page',[
            'providers' => Provider::all(),
            'brands' => Brand::all(),
        ]);
    }

    function update()
    {
        $this->article_form->update();
        $this->article = Article::find($this->article->id);

        $this->dispatch('close-editArticle');
    }
}
