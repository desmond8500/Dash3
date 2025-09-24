<?php

namespace App\Livewire\Forms;

use App\Models\ErpDoc;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ErpDocForm extends Form
{
    public ErpDoc $doc;

    #[Rule('required')]
    public $name;
    public $type;
    #[Rule('required')]
    public $path;
    public $extension;

    function fix(){
        $this->name = ucfirst($this->name);
    }


    function store(){
        $this->validate();
        $this->fix();
        $doc = ErpDoc::create($this->all());

        if ($this->path) {
            $this->storeAvatar($doc, $this->path);
        }
    }

    function set($model_id){
        $this->doc = ErpDoc::find($model_id);
        $this->name = $this->doc->name;
        $this->type = $this->doc->type;
        $this->path = $this->doc->path;
        $this->extension = $this->doc->extension;
    }

    function storeAvatar($doc, $path, $delete = false){
        if (!is_string($this->path)) {
            $dir = "erp/documents/$doc->id";
            if ($delete) {
                Storage::disk('public')->deleteDirectory($dir);
            }
            $name = $path->getClientOriginalName();
            $path->storeAs("public/$dir", $name);

            $doc->path = "storage/$dir/$name";
            pathinfo($name, PATHINFO_EXTENSION);
            $doc->extension = pathinfo($name, PATHINFO_EXTENSION);
            $doc->save();
        }
    }

    function update(){
        $this->validate();
        $this->doc->update($this->only('name','type'));
    }

    function delete($model_id){
        $this->doc = ErpDoc::find($model_id);
        unlink($this->doc->path);
        rmdir(dirname($this->doc->path));
        $this->doc->delete();
    }
}
