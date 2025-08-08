<?php

namespace App\Livewire\Stock;

use App\Http\Controllers\ImageController;
use App\Livewire\Forms\ProviderForm;
use App\Models\Article;
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
        return Provider::orderBy('name')->where('name', 'like', '%' . $this->search . '%')->paginate(15);
    }

    public function render()
    {
        return view('livewire.stock.providers-page',[
            'providers' => $this->ProviderSearch(),
        ]);
    }

    public $provider;
    public ProviderForm $provider_form;

    function edit($id)
    {
        $this->provider_form->set($id);
        $this->dispatch('open-editProvider');
    }

    function update()
    {
        $this->provider_form->update();
        $this->dispatch('close-editProvider');
    }

    function delete($id)
    {
        $articles =  Article::where('provider_id', $id)->count();
        if ($articles) {
            $this->js("alert('Ce fournisseur a $articles articles liés')");
        } else {
            $this->provider_form->delete($id);
        }
    }

    // Logo
    public $logo;
    public $provider_id;

    function edit_logo($id){
        $this->provider_id = $id;
        $this->dispatch('open-editLogo');
    }

    function update_logo()
    {
        $dir = "stock/providers/$this->provider_id/logo";
        $provider = Provider::find($this->provider_id);
        $provider->logo = ImageController::update_logo($dir, $this->logo);;
        $provider->save();
        $this->dispatch('close-editLogo');
        $this->reset('logo');
    }

}
