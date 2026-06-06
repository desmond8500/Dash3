<?php

namespace App\Livewire\Stock;

use App\Http\Controllers\ArticleController;
use App\Livewire\Forms\ItemForm;
use App\Models\Article;
use App\Models\Brand;
use App\Models\Commande;
use App\Models\Provider;
use App\Models\Setting;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Spatie\Tags\Tag;

class ArticlesPage extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';
    public string $search ='';
    public array $breadcrumbs;
    public ItemForm $article_form;
    public int $paginate = 12;
    public $card = "col-md-6 col-xl-4";

    public function mount(){
        $settings = \App\Models\Setting::where('user_id', auth()->user()->id)->first();;

        if ($settings->size =='container-fluid') {
            $this->paginate = 12;
        }


        $this->breadcrumbs = array(
            array('name' => 'Stock', 'route' => route('stock')),
            array('name' => 'Articles', 'route' => route('articles')),
        );
    }

    public string $search_brand = '';
    public string $search_provider = '';

    #[On('get-articles')]
    public function render()
    {
        return view('livewire.stock.articles-page',[
            'articles' => $this->get_articles(),
            'providers' => Provider::search($this->search_provider, 'name')->get(),
            'brands' => Brand::search($this->search_brand, 'name')->get(),
            'tags' => Tag::getWithType('stock_article'),
            'priorites' => ArticleController::priorites(),
        ]);
    }

    public ?int $brand_id = 0;
    public ?int $provider_id = 0;
    public ?int $priorite_id = 25;

    public ?array $tag = null;
    public ?string $selectedtag = null;

    function get_articles(){

        return Article::query()

            ->when(
                $this->brand_id,
                fn($q) => $q->where('brand_id', $this->brand_id)
            )

            ->when(
                $this->provider_id,
                fn($q) => $q->where('provider_id', $this->provider_id)
            )

            ->when(
                $this->priorite_id != 25,
                fn($q) => $q->where('priority_id', $this->priorite_id)
            )

            ->when(
                $this->selectedtag,
                fn($q) => $q->withAnyTags([$this->selectedtag])
            )

            ->articleSearch($this->search)

            ->orderByDesc('id')

            ->paginate($this->paginate);
    }

    function reset_filter(){
        $this->reset('brand_id', 'provider_id', 'priorite_id', "search", "selectedtag");
    }

    public int $selected = 0;

    function edit(int $article_id){
        $this->article_form->set($article_id);
        $this->selected = $article_id;

        $this->dispatch('open-editArticle');
    }

    function update(){
        $this->article_form->update();

        $this->dispatch('close-editArticle');
    }

    // TODO: Voir les dépendnces de suppression
    function delete(int $article_id){
        $this->article_form->delete($article_id);
    }

    function dupliquer(int $article_id){
        $article = Article::find($article_id);

        $new = $article->replicate();
        $new->save();
    }

    function buy(int $article_id){
        Commande::create([
            'article_id' => $article_id,
            'quantity' => 1,
        ]);
    }

    function convert_euro(){
        $this->article_form->price *= 655;
    }
    function add_tva(){
        $this->article_form->price *= 1.2;
    }

    function uppercase(){
        $this->article_form->reference = strtoupper($this->article_form->reference);
    }

}
