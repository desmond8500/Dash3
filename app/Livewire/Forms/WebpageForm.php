<?php

namespace App\Livewire\Forms;

use App\Models\Webpage;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class WebpageForm extends Form
{
    public Webpage $webpage;

    #[Rule('required|numeric')]
    public $webpage_category_id;
    #[Rule('required')]
    public $name;
    #[Rule('required|url')]
    public $url;
    public $logo;
    public $description;
    public $favorite;

    function fix(){
        $this->name = ucfirst($this->name);
    }

    function store(){
        $this->fix();
        $this->validate();
        $webpage = Webpage::create($this->all());
        if ($this->logo) {
            $this->storeAvatar($webpage, $this->logo);
        }
    }

    function storeAvatar($webpage, $logo, $delete = false){
        if (!is_string($this->logo)) {
            $dir = "modules/webpage/$webpage->id/logo";
            if ($delete) {
                Storage::disk('public')->deleteDirectory($dir);
            }
            $name = $logo->getClientOriginalName();
            $logo->storeAs("public/$dir", $name);

            $webpage->logo = "storage/$dir/$name";
            $webpage->save();
        }
    }
    function set($model_id){
        $this->webpage = Webpage::find($model_id);
        $this->webpage_category_id = $this->webpage->webpage_category_id;
        $this->name = $this->webpage->name;
        $this->logo = $this->webpage->logo;
        $this->description = $this->webpage->description;
        $this->url = $this->webpage->url;
        $this->favorite = $this->webpage->favorite;
    }

    function update(){
        $this->fix();
        $this->validate();
        $this->webpage->update($this->only(['webpage_category_id', 'name', 'description', 'url']));

        if ($this->logo) {
            $this->storeAvatar($this->webpage, $this->logo);
        }

    }

    function delete($model_id){
        $this->webpage = Webpage::find($model_id);
        $this->webpage->delete();
    }

    function favorite($id)
    {
        $this->set($id);
        if ($this->favorite) {
            $this->favorite = 0;
        } else {
            $this->favorite = 1;
        }
        $this->webpage->update($this->only('favorite'));
    }
}
