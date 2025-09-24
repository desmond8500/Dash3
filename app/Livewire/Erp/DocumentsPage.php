<?php

namespace App\Livewire\Erp;

use App\Livewire\Forms\ErpDocForm;
use App\Models\ErpDoc;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class DocumentsPage extends Component
{
    use WithPagination;
    use WithFileUploads;
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
        return view('livewire.erp.documents-page',[
            'documents' => ErpDoc::search($this->search)->paginate(10),
        ]);
    }

    public ErpDocForm $document_form;
    public $search;

    function store(){
        $this->document_form->store();
        $this->dispatch('close-addDocument');
    }

    function edit($id){
        $this->document_form->set($id);
        $this->dispatch('open-editDocument');
    }

    function update(){
        $this->document_form->update();
        $this->dispatch('close-editDocument');
    }

    function delete($id){
        $this->document_form->delete($id);
    }
}
