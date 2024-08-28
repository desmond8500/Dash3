<?php

namespace App\Livewire\Forms;

use App\Models\BuildingDocument;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class BuildingDocumentForm extends Form
{
    public BuildingDocument $document;

    #[Rule('required')]
    public $building_id;
    public $name;
    public $link;
    public $folder;

    function fix(){
        $this->name = ucfirst($this->name);
    }


    function store(){
        $this->validate();
        $document = BuildingDocument::create($this->all());

        $this->storeAvatar($document, $this->folder);

    }

    function storeAvatar($document, $folder, $delete = false){
        if (!is_string($folder)) {
            $dir = "erp/documents/buildings/$document->building_id/$document->id";
            if ($delete) {
                Storage::disk('public')->deleteDirectory($dir);
            }
            $name = $folder->getClientOriginalName();
            $folder->storeAs("public/$dir", $name);

            $document->folder = "storage/$dir/$name";
            $document->save();
        }
    }

    function set($model_id){
        $this->document = BuildingDocument::find($model_id);
        $this->building_id = $this->document->building_id;
        $this->name = $this->document->name;
        $this->link = $this->document->link;
        $this->folder = $this->document->folder;


    }

    function update(){
        $this->validate();
        $this->document->update($this->all());
    }

    function delete(){
        $this->document->delete();
    }
}
