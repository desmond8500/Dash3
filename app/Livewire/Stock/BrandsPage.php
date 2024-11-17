<?php

namespace App\Livewire\Stock;

use App\Http\Controllers\ImageController;
use App\Livewire\Forms\BrandForm;
use App\Models\Article;
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
        return Brand::orderBy('name')->where('name', 'like', '%' . $this->search . '%')->paginate(21);
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
        $articles = Article::where('brand_id', $id)->count();

        if ($articles) {
            if ($articles >= 1) {
                $this->js("alert('Cette marque est liée à un article' )");
            }else{
                $this->js("alert('Cette marque est liée à $articles articles ' )");
            }
        } else {
            $this->brand_form->delete($id);
        }
    }

    // Logo
    public $logo;
    public $brand_id;

    function edit_logo($brand_id){
        $this->brand_id = $brand_id;
        $this->dispatch('open-editBrandLogo');
    }

    function update_logo()
    {
        $dir = "stock/brands/$this->brand_id/logo";
        $brand = Brand::find($this->brand_id);
        $brand->logo = ImageController::update_logo($dir, $this->logo);;
        $brand->save();
        $this->dispatch('close-editBrandLogo');
        $this->reset('logo');
    }
}
