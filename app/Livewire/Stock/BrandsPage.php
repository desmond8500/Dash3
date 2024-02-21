<?php

namespace App\Livewire\Stock;

use App\Models\ArticleBrand;
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
        return ArticleBrand::where('name', 'like', '%' . $this->search . '%')->paginate(10);
    }

    public function render()
    {
        return view('livewire.stock.brands-page',[
            'articles' => $this->brandSearch(),
            'brands' => $this->brandSearch(),
        ]);
    }
}
