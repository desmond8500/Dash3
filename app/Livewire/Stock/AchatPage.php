<?php

namespace App\Livewire\Stock;

use App\Livewire\Forms\AchatRowForm;
use App\Models\Achat;
use App\Models\AchatRow;
use App\Models\Article;
use App\Models\Provider;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class AchatPage extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';
    public $search ='';
    public $breadcrumbs;
    public $achat_id;
    public $achat;

    public $provider_id;
    #[Validate('required')]
    public $name;
    public $description;
    #[Validate('required')]
    public $date;

    public function mount($achat_id){
        $this->achat = Achat::find($achat_id);
        $this->breadcrumbs = array(
            array('name' => 'Stock', 'route' => route('stock')),
            array('name' => 'Achats', 'route' => route('achats')),
            array('name' => 'Achat', 'route' => route('achat',['achat_id'=>$achat_id])),
        );
    }

    function AchatSearch() {
        return Achat::where('name', 'like', '%' . $this->search . '%')->paginate(10);
    }

    public function render(){
        return view('livewire.stock.achat-page',[
            'achat' => $this->achat,
            'articles' => Article::all(),
            'providers' => Provider::all(),
        ]);
    }

    public $selected;

    function edit($provider_id)
    {
        $achat =  Achat::find($provider_id);
        $this->selected = $provider_id;

        $this->provider_id = $achat->provider_id;
        $this->name = $achat->name;
        $this->description = $achat->description;
        $this->date = $achat->date;

        $this->dispatch('open-editAchat');
    }

    function update()
    {
        $this->validate();

        $achat =  Achat::find($this->selected);

        $achat->name = ucfirst($this->name);
        $achat->description = ucfirst($this->description);
        $achat->date = $this->date;
        $achat->save();
        $this->achat = $achat;

        $this->dispatch('close-editAchat');
    }

    public $row_quantity = 1;
    public $row_tva = false;

    function row_store($id){
        $article = Article::find($id);

        AchatRow::create([
            'achat_id' => $this->achat->id,
            'designation' => $article->designation,
            'reference' => $article->reference,
            'quantite' => $this->row_quantity,
            'prix' => $article->price,
            'tva' => $this->row_tva ? 0.18 : 0,
        ]);
        $this->dispatch('close-addAchatArticle');

    }

    public AchatRowForm $a_row;

    function row_edit($id){
        $this->a_row->set($id);
        $this->dispatch('open-editAchatRow');
    }

    function row_update()
    {
        $this->a_row->update();

        $this->dispatch('close-editAchatRow');
    }

    function row_delete($id){
        $this->a_row->delete($id);
    }

}


