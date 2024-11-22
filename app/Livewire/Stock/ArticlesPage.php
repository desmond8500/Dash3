<?php

namespace App\Livewire\Stock;

use App\Livewire\Forms\ArticleForm;
use App\Livewire\Forms\ItemForm;
use App\Models\Article;
use App\Models\Brand;
use App\Models\Commande;
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
    public ItemForm $article_form;

    public function mount(){
        $this->breadcrumbs = array(
            array('name' => 'Stock', 'route' => route('stock')),
            array('name' => 'Articles', 'route' => route('articles')),
        );

        $this->priorites = (object) array(
            (object) array('name' => 'Centrale 1', 'id' => 0),
            (object) array('name' => 'Centrale 2', 'id' => 1),
            (object) array('name' => 'Organe 1', 'id' => 2),
            (object) array('name' => 'Organe 2', 'id' => 3),
            (object) array('name' => 'Organe 3', 'id' => 4),
            (object) array('name' => 'Cable 1', 'id' => 5),
            (object) array('name' => 'Accessoire', 'id' => 6),
            (object) array('name' => 'Forfait', 'id' => 7),
        );
    }

    #[On('get-articles')]
    public function render()
    {
        return view('livewire.stock.articles-page',[
            'articles' => $this->get_articles(),
            'providers' => Provider::all(),
            'brands' => Brand::all(),
        ]);
    }

    public $brand_id;
    public $provider_id;
    public $priorite_id = 25;

    public $priorites;

    function get_articles(){
        if ($this->brand_id) {
            return Article::orderByDesc('id')->where('brand_id', $this->brand_id)->articleSearch($this->search)->paginate(8);
        }
        if ($this->provider_id) {
            return Article::orderByDesc('id')->where('provider_id', $this->provider_id)->articleSearch($this->search)->paginate(8);
        }
        if ($this->priorite_id != 25 ) {
            return Article::orderByDesc('id')->where('priority_id', $this->priorite_id)->articleSearch($this->search)->paginate(8);
        }
        return Article::orderByDesc('id')->articleSearch($this->search)->paginate(8);
    }

    function reset_filter(){
        $this->reset('brand_id', 'provider_id', 'priorite_id');
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
    function delete($article_id){
        $this->article_form->delete($article_id);
    }

    function dupliquer($article_id){
        $article = Article::find($article_id);

        $new = $article->replicate();
        $new->save();
    }

    function buy($article_id){
        Commande::create([
            'article_id' => $article_id,
            'quantity' => 1,
        ]);
    }

    function convert_euro(){
        $this->article_form->price *= 655;
    }

    function uppercase(){
        $this->article_form->reference = strtoupper($this->article_form->reference);
    }

}
