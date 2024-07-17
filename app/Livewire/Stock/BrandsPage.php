<?php

namespace App\Livewire\Stock;

use App\Livewire\Forms\BrandForm;
use App\Models\Brand;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class BrandsPage extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $breadcrumbs;

    public function mount()
    {
        $this->breadcrumbs = array(
            array('name' => 'Stock', 'route' => route('stock')),
            array('name' => 'Marques', 'route' => route('brands')),
        );
    }

    #[On('get-brands')]
    function brandSearch()
    {
        return Brand::where('name', 'like', '%' . $this->search . '%')->paginate(18);
    }

    public function render()
    {
        return view('livewire.stock.brands-page',[
            'articles' => $this->brandSearch(),
            'brands' => $this->brandSearch(),
        ]);
    }

    public BrandForm $brand_form;

    function edit_brand($id){
        $this->brand_form->set($id);
        $this->dispatch('open-editBrand');
    }

    function update_brand(){
        $this->brand_form->update();
        $this->dispatch('close-editBrand');
    }

    function delete_brand($id){
        $this->brand_form->delete($id);
    }
}
