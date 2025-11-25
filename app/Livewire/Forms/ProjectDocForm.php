<?php

namespace App\Livewire\Forms;

use App\Models\ProjectDoc;
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
        // $this->validate();
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

    function delete($model_id){
        $this->doc = ProjectDoc::find($model_id);

        unlink($this->doc->document_path);
        // rmdir(dirname(this->doc->path));

        $this->doc->delete();
    }

    function storeFile($doc, $file)
    {
        if (!is_string($this->document_path)) {
            $dir = "erp/clients/".$doc->projet->client->id."/"."projects/".$doc->projet->id."/documents";

            $name = $file->getClientOriginalName();
            $file->storeAs("public/$dir", $name);

            $doc->folder = "storage/$dir/$name";
            $doc->save();
        }
    }
}
