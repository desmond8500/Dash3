<?php

namespace App\Livewire\Forms;

use App\Models\Objet;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ObjetForm extends Form
{
    public Objet $objet;

    public $id;
    #[Rule('required')]
    public $installation_id;
    public $parent_id;
    public $article_id;
    #[Rule('required')]
    public $name;
    public $description;
    public $type;
    public $attributs = [];


    function fix(){
        $this->name = ucfirst($this->name);
    }

    function store(){
        $this->validate();
        Objet::create($this->all());
    }

    function set($model_id){
        $this->objet = Objet::find($model_id);
        $this->id = $model_id;
        $this->name = $this->objet->name;
        $this->installation_id = $this->objet->installation_id;
        $this->description = $this->objet->description;
        $this->type = $this->objet->type;
        $this->article_id = $this->objet->article_id;
        $this->attributs = $this->objet->attributs;
    }

    function update(){
        $this->validate();
        $this->objet->update($this->all());
    }

    function delete(){
        $this->objet = Objet::find($this->id);

        // unlink(this->objet->path);
        // rmdir(dirname(this->objet->path));

        $this->objet->delete();
    }

    function add_attribut(){
        $this->attributs[] = ['name' => '', 'value' => ''];
        $this->objet->update($this->only(['attributs']));
    }
}
