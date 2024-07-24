<?php

namespace App\Livewire\Stock;

use App\Models\Achat;
use App\Models\Article;
use App\Models\Brand;
use App\Models\Provider;
use Livewire\Component;

class StockPage extends Component
{
    public $breadcrumbs;
    public $count;

    public function mount()
    {
        $this->breadcrumbs = array(
            array('name' => 'Stock', 'route' => route('stock')),
        );

        $this->count = array(
            'articles'=> Article::count(),
            'achats'=> Achat::count(),
            'brands'=> Brand::count(),
            'providers'=> Provider::count(),
        );
    }

    public $sections = array(
         array( 'name'=> 'Articles', 'route'=>'articles'),
         array( 'name'=> 'Achats', 'route'=>'achats'),
         array( 'name'=>'Marques', 'route'=>'brands'),
         array( 'name'=> 'Fournisseurs', 'route'=>'providers'),
    );
    public function render()
    {
        return view('livewire.stock.stock-page');
    }
}
