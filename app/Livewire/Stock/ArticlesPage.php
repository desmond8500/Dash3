<?php

namespace App\Livewire\Stock;

use App\Http\Controllers\AchatController;
use App\Livewire\Forms\ArticleForm;
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
    public ArticleForm $article_form;

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
        $this->article_form->set($article_id);

        $this->dispatch('open-editArticle');
    }

    function update(){
        $this->article_form->update();

        $this->dispatch('close-editArticle');
    }

    // TODO: Voir les dépendnces de suppression
    function delete(){
        AchatController::delete($this->selected);
        $this->dispatch('close-editArticle');
    }

}
