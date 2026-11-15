<?php

namespace App\Livewire\Stock;

use App\Models\Article;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class ArticleDownload extends Component
{
    public string $search = '';
    public array $breadcrumbs;
    public mixed $articles;
    public int $page=1;
    public string $server_url = "https://dash3.yonkou.info/api/v1/items";

    public function mount()
    {
        $this->articles = $this->get_articles();
        $this->breadcrumbs = array(
            array('name' => 'Stock', 'route' => route('stock')),
            array('name' => 'Articles', 'route' => route('articles')),
        );
    }
    public function render()
    {
        return view('livewire.stock.article-download',[
            'articles' => $this->articles,
        ]);
    }

    function store(int $article_id){
        $article = Http::get("{$this->server_url}/{$article_id}");

        $article = $article['data'];

        Article::create([
            'designation' => $article['designation'],
            'description' => $article['description'],
            'image' => $article['image'],
            'price' => $article['price'],
            'brand_id' => $article['brand_id'],
            'provider_id' => $article['provider_id'],
        ]);
    }
    public string $article_search = "";
    function get_articles($page=1){
        $query = Http::get('https://dash3.yonkou.info/api/v1/items?page='.$page.'&search='.$this->article_search);

        return $query->json();
    }

    function nextPage(){
        $this->page++;
        $this->articles = $this->get_articles($this->page);

    }
    function previousPage(){
        $this->page--;
        $this->articles = $this->get_articles($this->page);
    }

    function edit_server(string $server_url){
        $this->server_url = $server_url;
    }
}
