<?php

namespace App\Livewire\Stock;

use Livewire\Component;

class StockPage extends Component
{
    public $breadcrumbs;

    public function mount()
    {
        $this->breadcrumbs = array(
            array('name' => 'Stock', 'route' => route('stock')),
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
