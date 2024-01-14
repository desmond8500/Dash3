<?php

namespace App\Livewire\Stock;

use App\Http\Controllers\AchatController;
use App\Models\Article;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
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

    public function mount(){
        $this->breadcrumbs = array(
            array('name' => 'Stock', 'route' => route('stock')),
            array('name' => 'Articles', 'route' => route('articles')),
        );
    }

    #[On('close-addArticle')]
    function articleSearch() {
        return Article::where('designation', 'like', '%' . $this->search . '%')->orWhere('reference', 'like', '%' . $this->search . '%')->paginate(10);
    }

    public function render()
    {
        return view('livewire.stock.articles-page',[
            'articles' => $this->articleSearch(),
        ]);
    }

    #[Validate('required')]
    public $designation;
    public $image;
    public $reference;
    public $description;
    #[Validate('numeric')]
    public $quantity = 0;
    #[Validate('numeric')]
    public $priority_id = 0;
    #[Validate('numeric')]
    public $brand_id = 0;
    #[Validate('numeric')]
    public $provider_id = 0;
    #[Validate('numeric')]
    public $price = 0;

    public $selected;

    function edit($article_id){
        $article =  Article::find($article_id);
        $this->selected = $article_id;

        $this->designation = $article->designation;
        $this->reference = $article->reference;
        $this->description = $article->description;
        $this->quantity = $article->quantity;
        $this->priority_id = $article->priority_id;
        $this->brand_id = $article->brand_id;
        $this->provider_id = $article->provider_id;
        $this->price = $article->price;

        $this->dispatch('open-editArticle');
    }

    function update(){
        $this->validate();

        $article =  Article::find($this->selected);

        $article->designation = $this->designation;
        $article->reference = $this->reference;
        $article->description = $this->description;
        $article->quantity = $this->quantity;
        $article->priority_id = $this->priority_id;
        $article->brand_id = $this->brand_id;
        $article->provider_id = $this->provider_id;
        $article->price = $this->price;
        $article->save();

        $this->dispatch('close-editArticle');
    }

    // TODO: Voir les dépendnces de suppression
    function delete(){
        AchatController::delete($this->selected);
        $this->dispatch('close-editArticle');
    }

}
