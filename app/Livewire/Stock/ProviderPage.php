<?php

namespace App\Livewire\Stock;

use App\Http\Controllers\ImageController;
use App\Livewire\Forms\ProviderForm;
use App\Models\Article;
use App\Models\Provider;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProviderPage extends Component
{
    use WithFileUploads;

    public $provider_id;
    public $breadcrumbs;

    function mount($provider_id){
        $this->provider_id = $provider_id;

        $this->breadcrumbs = array(
            array('name' => 'Stock', 'route' => route('stock')),
            array('name' => 'Fournisseurs', 'route' => route('providers')),
            array('name' => 'Fournisseur', 'route' => route('provider',['provider_id'=>$provider_id])),
        );
    }
    public function render()
    {
        return view('livewire.stock.provider-page',[
            'provider' => Provider::find($this->provider_id),
            'articles' => Article::where('provider_id', $this->provider_id)->get(),
        ]);
    }

    public ProviderForm $provider_form;

    function edit(){
        $this->provider_form->set($this->provider_id);
        $this->dispatch('open-editProvider');
    }

    function update(){
        $this->provider_form->update();
        $this->dispatch('close-editProvider');
    }

    // Logo
    public $logo;

    function update_logo()
    {
        $dir = "stock/providers/$this->provider_id/logo";
        $provider = Provider::find($this->provider_id);
        $provider->logo = ImageController::update_logo($dir, $this->logo);;
        $provider->save();
        $this->dispatch('close-editLogo');
    }
}
