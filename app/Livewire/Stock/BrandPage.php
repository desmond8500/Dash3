<?php

namespace App\Livewire\Stock;

use App\Livewire\Forms\BrandForm;
use App\Models\Article;
use App\Models\Brand;
use Livewire\Component;

class BrandPage extends Component
{
    public $brand_id;
    public $breadcrumbs;
    public $search;
    public BrandForm $brand_form;

    public function mount($brand_id)
    {
        $brand = Brand::find($brand_id);
        $this->breadcrumbs = array(
            array('name' => 'Stock', 'route' => route('stock')),
            array('name' => 'Marques', 'route' => route('brands')),
            array('name' => $brand->id, 'route' => route('brand',['brand_id'=>$this->brand_id])),
        );
    }

    public function render()
    {
        return view('livewire.stock.brand-page',[
            'brand' => Brand::find($this->brand_id),
            'articles' => Article::where('brand_id', $this->brand_id)->search($this->search,'designation')->get(),
        ]);
    }

    function edit_brand($brand_id){
        $this->brand_form->set($brand_id);
        $this->dispatch('open-editBrand');
    }
    function update_brand(){
        $this->brand_form->update();
        $this->dispatch('close-editBrand');
    }
}
