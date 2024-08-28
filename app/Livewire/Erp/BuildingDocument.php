<?php

namespace App\Livewire\Erp;

use App\Livewire\Forms\BuildingDocumentForm;
use App\Models\BuildingDocument as ModelsBuildingDocument;
use Livewire\Component;

class BuildingDocument extends Component
{
    public $building_id;
    public BuildingDocumentForm $document_form;

    function mount($building_id)
    {
        $this->building_id = $building_id;
        $this->document_form->building_id = $building_id;
    }

    public function render()
    {
        return view(
        'livewire.erp.building-document', [
            'documents' => ModelsBuildingDocument::where('building_id', $this->building_id)->get(),
        ]);
    }
}
