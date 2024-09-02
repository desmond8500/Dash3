<?php

namespace App\Livewire\Stock;

use App\Livewire\Forms\InvoiceForm;
use App\Models\Article;
use App\Models\Brand;
use App\Models\Provider;
use Livewire\Attributes\On;
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
    public InvoiceForm $article_form;

    public function mount($article_id){
        $this->article = Article::find($article_id);
        $this->article_form->set($article_id);

        $this->breadcrumbs = array(
            array('name' => 'Stock', 'route' => route('stock')),
            array('name' => 'Articles', 'route' => route('articles')),
            array('name' => 'Article', 'route' => route('article',['article_id'=>$article_id])),
        );
    }

    #[On('refresh-article')]
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

    public $files;
    public $images;

    function store_files(){
        $article = Article::find($this->article->id);
        $dir = "stock/articles/" . $article->id . "/images";

        if ($this->images) {
            foreach ($this->images as $key => $photo) {
                $name = $photo->getClientOriginalName();
                $photo->storeAS("public/$dir", $name);
            }
        }
        $this->reset('images');
    }

    function set_image($image){
        $article = Article::find($this->article->id);
        $article->image = "storage/$image";
        $article->save();
    }
    function unset_image($image){
        unlink("storage/$image");
    }
}
