<?php

namespace App\Livewire\Forms;

use App\Models\Myproject;
use Illuminate\Container\Attributes\Storage;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;


class MyprojectForm extends Form
{
    public Myproject $project;


    #[Rule('required|integer')]
    public $user_id;
    #[Rule('required')]
    public $name;
    public $logo;
    public $logo2;
    public $favorite = false;
    public $description;

    function fix(){
        $this->name = ucfirst($this->name);
    }

    function store(){
        $this->fix();
        $this->user_id = auth()->user()->id;
        $this->validate();
        $projet = Myproject::create($this->all());

        if ($this->logo){
            $this->storeAvatar($projet, $this->logo);
        }
    }

    function get_id(){
        return $this->project->id;
    }

    function set($model_id){
        $this->project = Myproject::find($model_id);
        $this->user_id = $this->project->user_id;
        $this->name = $this->project->name;
        $this->logo = $this->project->logo;
        $this->favorite = $this->project->favorite;
        $this->description = $this->project->description;
    }

    function storeAvatar($myproject, $logo, $delete = true){
        if (!is_string($this->logo)) {
            $dir = "Project/$myproject->id/logo";
            if ($delete) {
                Storage::disk('public')->deleteDirectory($dir);
            }
            $name = $logo->getClientOriginalName();
            $logo->storeAs("public/$dir", $name);

            $myproject->logo = "storage/$dir/$name";
            $myproject->save();
        }
    }

    function update(){
        $this->validate();
        $this->fix();
        $this->project->update($this->only('user_id', 'name', 'favorite', 'description'));

        $projet = $this->project;

        if ($this->logo) {
            $this->storeAvatar($projet, $this->logo);
        }

        $projet->save();
    }

    function delete($model_id){
        $this->project = Myproject::find($model_id);
        $this->project->delete();
    }
}
