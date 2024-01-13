<?php

namespace App\Livewire\Stock;

use App\Models\Provider;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithPagination;

class ProvidersPage extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';
    public $search ='';
    public $breadcrumbs;

    public function mount(){
        $this->breadcrumbs = array(
            array('name' => 'Stock', 'route' => route('stock')),
            array('name' => 'Fournisseurs', 'route' => route('providers')),
        );
    }

    #[On('close-addProvider')]
    function ProviderSearch() {
        return Provider::where('name', 'like', '%' . $this->search . '%')->paginate(10);
    }

    public function render()
    {
        return view('livewire.stock.providers-page',[
            'providers' => $this->ProviderSearch(),
        ]);
    }

    #[Validate('required')]
    public $name;
    public $logo;
    public $address;
    public $description;
    public $selected;

    function edit($provider_id){
        $this->selected = $provider_id;
        $provider = Provider::find($provider_id);

        $this->name = $provider->name;
        $this->logo = $provider->logo;
        $this->address = $provider->address;
        $this->description = $provider->description;

        $this->dispatch('open-editProvider');
    }
    function update(){
        $provider = Provider::find($this->selected);
        $this->validate();

        $provider->name = $this->name;
        $provider->logo = $this->logo;
        $provider->address = $this->address;
        $provider->description = $this->description;
        $provider->save();

        $this->dispatch('close-editProvider');

    }

    function delete(){
        $provider = Provider::find($this->selected);
        $provider->delete();
        $this->dispatch('close-editProvider');
    }


}
