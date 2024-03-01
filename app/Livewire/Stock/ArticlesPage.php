<?php

namespace App\Livewire\Stock;

use App\Livewire\Forms\ArticleForm;
use App\Models\Article;
use App\Models\Brand;
use App\Models\Provider;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ArticlesPage extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';
    public $search ='';
    public $breadcrumbs;
    public ArticleForm $article_form;

    public function mount(){
        $this->breadcrumbs = array(
            array('name' => 'Stock', 'route' => route('stock')),
            array('name' => 'Articles', 'route' => route('articles')),
        );
    }

    #[On('get-articles')]
    function articleSearch() {
        return Article::where('designation', 'like', '%' . $this->search . '%')->orWhere('reference', 'like', '%' . $this->search . '%')->paginate(10);
    }

    public function render()
    {
        return view('livewire.stock.articles-page',[
            'articles' => $this->articleSearch(),
            'providers' => Provider::all(),
            'brands' => Brand::all(),
        ]);
    }

    public $selected;

    function edit($article_id){
        $this->article_form->set($article_id);
        $this->selected = $article_id;

        $this->dispatch('open-editArticle');
    }

    function update(){
        $this->article_form->update();

        $this->dispatch('close-editArticle');
    }

    // TODO: Voir les dépendnces de suppression
    function delete(){
        $article = Article::find($this->selected);
        $article->delete();
        $this->dispatch('get-articles');
    }

    function dupliquer($article_id){
        $article = Article::find($article_id);

        $new = $article->replicate();
        $new->save();
    }

    public $files;

    public store_files(){

    }

}
