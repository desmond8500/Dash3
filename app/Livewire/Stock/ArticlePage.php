<?php

namespace App\Livewire\Stock;

use App\Livewire\Forms\ItemForm;
use App\Models\Article;
use App\Models\Brand;
use App\Models\Provider;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Tags\Tag;

class ArticlePage extends Component
{
    // use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';
    public $search ='';
    public $breadcrumbs;
    public $article_id;
    public ItemForm $article_form;

    public function mount($article_id){
        $this->article_id = $article_id;
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
            'article' => Article::find($this->article_id),
            "tags" => Tag::getWithType('stock_article'),
        ]);
    }

    function edit($article_id){
        $this->article_form->set($article_id);
        $this->dispatch('open-editArticle');
    }

    function update()
    {
        $this->article_form->update();
        $this->dispatch('close-editArticle');
    }

    public $files;
    public $images;

    function store_files(){
        $article = Article::find($this->article_id);
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
        $article = Article::find($this->article_id);
        $article->image = "storage/$image";
        $article->save();
        $this->dispatch('refresh-article');
    }
    function unset_image($image){
        unlink("storage/$image");
    }

    function add_tva(){
        $this->article_form->price = $this->article_form->price * 1.18;
    }

    // Tags
    public $tag_name;
    public $tag_search;

    public function add_tag($tag = null)
    {
        $this->validate([
            'tag_name' => 'required|string|max:255',
        ]);
        if ($tag == null) {
            Tag::findOrCreate(strtolower($this->tag_name), 'stock_article');
            // Tag::create(['name' => strtolower($this->tag_name), 'type' => 'stock_article']);
            $this->tag_name = '';
        } else {
            Tag::findOrCreate(strtolower($tag), 'stock_article');
            // Tag::create(['name' => strtolower($tag), 'type' => 'stock_article']);
        }
        $this->dispatch('close-addTag');
    }

    function attach_tag($tag){
        $article = Article::find($this->article_id);
        $article->attachTag($tag);
        $this->dispatch('refresh-article');
    }
    function detach_tag($tag){
        $article = Article::find($this->article_id);
        $article->detachTag($tag);
        $this->dispatch('refresh-article');
    }

}
