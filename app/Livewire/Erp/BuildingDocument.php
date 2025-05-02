<?php

namespace App\Livewire\Erp;

use App\Livewire\Forms\BuildingDocumentForm;
use App\Models\BuildingDocument as ModelsBuildingDocument;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithPagination;

class BuildingDocument extends Component
{
    use WithFileUploads;
    use WithPagination;
    public $building_id;
    public BuildingDocumentForm $document_form;

    function mount($building_id)
    {
        $this->building_id = $building_id;
        $this->document_form->building_id = $building_id;
    }

    public function render()
    {
        return view( 'livewire.erp.building-document', [
            'documents' => ModelsBuildingDocument::where('building_id', $this->building_id)->paginate(6),
        ]);
    }

    public $button = 'Valider';

    function store(){
        $this->document_form->store();
        $this->document_form->erase();
    }

    function edit($id){
        $this->document_form->set($id);
        $this->button = 'Modifier';
    }

    function update(){
        $this->document_form->update();
        $this->button = 'Valider';
        $this->document_form->erase();
    }

    function delete($id){
        $this->document_form->delete($id);
    }
}
