<?php

namespace App\Livewire\Stock;

use App\Models\Achat;
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
            'achats' => Achat::all()
        ]);
    }

    function store(){
        $this->validate();

        Achat::create([
            'provider_id'=> $this->provider_id,
            'name'=> $this->name,
            'description'=> $this->description,
            'date'=> $this->date,
        ]);
        $this->dispatch('close-addAchat');
    }
}
