<?php

namespace App\Livewire\Erp;

use Livewire\Component;
use Livewire\WithPagination;

class DocumentsPage extends Component
{
    use WithPagination;
    use WithPagination;
    public $breadcrumbs;
    protected $paginationTheme = 'bootstrap';

    public $fiches;


    public function mount()
    {
        $this->fiches = array(
            (object) array('name'=> "Fiche Inventaire", 'route'=> 'fiches_inventaire_pdf', 'type'=>'' , 'icon'=>'download'),
            (object) array('name'=> "Fiche de présence", 'route'=> 'fiches_pdf', 'type'=>'presence' , 'icon'=>'download'),
        );
        $this->breadcrumbs = array(
            array('name' => 'Documents', 'route' => route('documents')),
        );
    }

    public function render()
    {
        return view('livewire.erp.documents-page');
    }
}
