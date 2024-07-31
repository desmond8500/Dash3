<?php

namespace App\Livewire\Stock;

use App\Livewire\Forms\AchatForm;
use App\Livewire\Forms\AchatRowForm;
use App\Models\Achat;
use App\Models\AchatFacture;
use App\Models\AchatRow;
use App\Models\Article;
use App\Models\Provider;
use Barryvdh\DomPDF\Facade\Pdf;
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
    public AchatForm $achat_form;

    public $provider_id;
    #[Validate('required')]
    public $name;
    public $description;
    #[Validate('required')]
    public $date;

    public function mount($achat_id){
        $this->achat_form->set($achat_id);
        $this->achat = Achat::find($achat_id);
        $this->breadcrumbs = array(
            array('name' => 'Stock', 'route' => route('stock')),
            array('name' => 'Achats', 'route' => route('achats')),
            array('name' => 'Achat', 'route' => route('achat',['achat_id'=>$achat_id])),
        );
    }

    #[On('get-achat')]
    public function render(){
        return view('livewire.stock.achat-page',[
            'achat' => $this->achat,
            'articles' => Article::search($this->search,'designation')->paginate(5),
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

    public $facture;

    function addFacture(){
        if ($this->facture) {
        $dir = "stock/achats/".$this->achat->id."/factures";
            $name = $this->facture->getClientOriginalName();
            $this->facture->storeAS("public/$dir", $name);
        }

        AchatFacture::create([
            'achat_id' => $this->achat->id,
            'folder' => "storage/$dir/$name",
        ]);
        $this->dispatch('close-addAchatFacture');
    }

    function delete_facture($id){
        $facture = AchatFacture::find($id);

        $file = public_path($facture->folder);
        unlink($file);
        $facture->delete();
    }

    function pdf(){
        // 'achat' => $this->achat
        $data = ['sdfs'];
        $data = mb_convert_encoding($data, 'UTF-8', 'UTF-8');

        // $pdf = Pdf::loadView('_pdf.achat', $data);
        $pdf = Pdf::loadView('welcome', $data);
        return $pdf->stream();
        // return $pdf->download('_pdf.achat');

        // Pdf::view('pdf.invoice')->save('/some/directory/invoice.pdf');
    }

    // Achat

    function achat_edit($achat_id)
    {
        $this->achat_form->set($achat_id);

        $this->dispatch('open-editAchat');
    }
    function achat_update()
    {
        $this->achat_form->update();
        $this->achat = Achat::find($this->achat->id);
        $this->dispatch('close-editAchat');
    }

}


