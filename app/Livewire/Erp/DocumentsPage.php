<?php

namespace App\Livewire\Erp;

use Livewire\Component;
use Livewire\WithPagination;

class DocumentsPage extends Component
{
    use WithPagination;
    public $breadcrumbs;
    protected $paginationTheme = 'bootstrap';


    public function mount()
    {
        $this->breadcrumbs = array(
            array('name' => 'Documents', 'route' => route('documents')),
        );
    }

    public function render()
    {
        return view('livewire.erp.documents-page');
    }
}
