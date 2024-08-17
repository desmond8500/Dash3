<?php

namespace App\Livewire\Forms;

use App\Models\ArticleDocument;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ArticleDocumentForm extends Form
{
    public ArticleDocument $document;

    #[Rule('required')]
    public $article_id;
    #[Rule('required')]
    public $folder;
    public $name;

    function fix()
    {
        $this->name = ucfirst($this->name);
    }

    function store()
    {
        $this->validate();
        $document = ArticleDocument::create($this->all());

        $this->storeFile($document, $this->folder);

    }

    function storeFile($document, $avatar, $delete = false){
        if (!is_string($this->folder)) {
            $dir = "stock/$this->article_id/document";
            if ($delete) {
                Storage::disk('public')->deleteDirectory($dir);
            }
            $name = $avatar->getClientOriginalName();
            $avatar->storeAs("public/$dir", $name);

            $document->folder = "storage/$dir/$name";
            $document->save();
        }
    }

    function set($model_id)
    {
        $this->document = ArticleDocument::find($model_id);
        $this->article_id = $this->document->article_id;
        $this->name = $this->document->name;
        $this->folder = $this->document->folder;
    }

    function update()
    {
        $this->validate();
        $this->document->update($this->all());
    }

    function delete()
    {
        $this->document->delete();
    }
}
