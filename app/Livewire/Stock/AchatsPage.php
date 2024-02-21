<?php

namespace App\Livewire\Stock;

use App\Models\Achat;
use App\Models\Provider;
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

    function edit($provider_id){
        $provider =  Achat::find($provider_id);
        $this->selected = $provider_id;

        $this->provider_id = $provider->provider_id;
        $this->name = $provider->name;
        $this->description = $provider->description;
        $this->date = $provider->date;

        $this->dispatch('open-editAchat');
    }

    function update()
    {
        $this->validate();

        $provider =  Achat::find($this->selected);

        $provider->provider_id = $this->provider_id;
        $provider->name = $this->name;
        $provider->description = $this->description;
        $provider->date = $this->date;
        $provider->save();

        $this->dispatch('close-editAchat');
    }

    // TODO: Voir les dépendnces de suppression
    function delete()
    {
        $article =  Achat::find($this->selected);
        $article->delete();
        $this->dispatch('close-editAchat');
    }
}
