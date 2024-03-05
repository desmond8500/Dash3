<?php

namespace App\Livewire\Erp;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class FinancesPage extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';
    public $search ='';
    public $breadcrumbs;

    public function mount(){
        $this->breadcrumbs = array(
            array('name' => 'Finances', 'route' => route('finances')),
        );
    }

    public function render()
    {
        return view('livewire.erp.finances-page');
    }
}
