<?php

namespace App\Livewire\Stock;

use App\Livewire\Forms\AchatForm;
use App\Models\Achat;
use App\Models\Provider;
use App\Models\Transaction;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class AchatsPage extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';
    public $search ='';
    public $breadcrumbs;

    public function mount(){
        $this->breadcrumbs = array(
            array('name' => 'Stock', 'route' => route('stock')),
            array('name' => 'Achats', 'route' => route('achats')),
        );
    }

    public $provider_id;
    #[Validate('required')]
    public $name;
    public $description;
    #[Validate('required')]
    public $date;

    #[On('close-addAchat')]
    function ProviderSearch()
    {
        return Achat::where('name', 'like', '%' . $this->search . '%')->paginate(10);
    }

    public function render()
    {
        return view('livewire.stock.achats-page',[
            'achats' => Achat::all(),
            'providers' => Provider::all()
        ]);
    }

    public $selected;
    public AchatForm $achat_form;

    function edit($achat_id){
        $this->achat_form->set($achat_id);
        $this->dispatch('open-editAchat');
    }

    function update()
    {
        $this->achat_form->update();
        $this->dispatch('close-editAchat');
    }

    // TODO: Voir les dépendnces de suppression
    function delete($achat_id)
    {
        $achat =  Achat::find($achat_id);

        if ($achat->rows->count() || $achat->factures->count()) {
            LivewireAlert::text("Impossible de supprimer cet achat car il contient des articles ou des factures.")
                ->position('top-end')
                ->toast()
                ->warning()
                ->show();
        }else{
            $achat->delete();

        }

        $this->dispatch('close-editAchat');
    }
    // Transaction

    function add_transaction($achat_id){
        $this->achat_form->add_transaction($achat_id);
    }
}
