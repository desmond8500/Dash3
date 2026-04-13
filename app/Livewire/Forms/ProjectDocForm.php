<?php

namespace App\Livewire\Forms;

use App\Models\ProjectDoc;
use App\Models\Projet;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ProjectDocForm extends Form
{
    public ProjectDoc $doc;

    #[Rule('required')]
    public $projet_id;
    public $document_name;
    public $document_path;

    function fix(){
        $this->document_name = ucfirst($this->document_name);
    }

    function store(){
        $this->validate();
        // $this->fix();
        $doc = ProjectDoc::create($this->all());

        $this->storeFile($doc, $this->document_path, $doc);
    }

    function set($model_id){
        $this->doc = ProjectDoc::find($model_id);
        $this->projet_id = $this->doc->projet_id;
        $this->document_name = $this->doc->document_name;
        $this->document_path = $this->doc->document_path;
    }

    function update(){
        $this->validate();
        $this->doc->update($this->all());
    }

    function delete(){
        try {
            unlink($this->doc->document_path);
            $this->doc->delete();
        } catch (\Throwable $th) {
            $this->doc->delete();
        }
    }

    function storeFile($doc, $file)
    {
        $projet = Projet::find($this->projet_id);
        if (!is_string($this->document_path)) {
            $dir = "erp/clients/".$projet->client->id."/"."projects/".$projet->id."/documents";

            $name = $file->getClientOriginalName();
            $file->storeAs("public/$dir", $name);

            $doc->document_path = "storage/$dir/$name";
            $doc->save();
        }
    }
}
