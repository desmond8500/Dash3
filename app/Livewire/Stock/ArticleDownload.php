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

    public function mount()
    {
        $this->articles = Http::get('https://dash3.yonkou.info/api/v1/items')->json();
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
        $article = Http::get("https://dash3.yonkou.info/api/v1/items/{$article_id}")->json();

        Article::create([
            'designation' => $article['designation'],
            'description' => $article['description'],
            'image' => $article['image'],
            'price' => $article['price'],
            'brand_id' => $article['brand_id'],
            'provider_id' => $article['provider_id'],
            'type_id' => $article['type_id'],
        ]);
    }
}
