<?php

namespace App\Livewire\Forms;

use App\Models\Images;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ImageForm extends Form
{
    public Images $image;

    #[Rule('required')]
    public $name;
    public $path;
    public $size;
    public $type;

    function fix(){
        $this->name = ucfirst($this->name);
    }

    function store(){
        // $this->validate();
        foreach ($this->name as $key => $avatar) {
            $image = Images::create(
                [
                    'name' => $avatar->getClientOriginalName(),
                    'path' => "storage/medias/images/{$avatar->getClientOriginalName()}",
                    'size' => $avatar->getSize(),
                    'type' => $avatar->getClientOriginalExtension(),
                ]
            );

            $this->storeAvatar($image, $avatar);
        }
    }

    function storeAvatar($client, $avatar, $delete = false){
        if (!is_string($this->name)) {
            $dir = "medias/images";
            if ($delete) {
                Storage::disk('public')->deleteDirectory($dir);
            }
            if (!Storage::exists("public/$dir")) {
                Storage::makeDirectory("public/$dir");
            }

            $name = $avatar->getClientOriginalName();
            $avatar->storeAs("public/$dir", $name);

            $client->name = "$name";
            $client->save();
        }
    }

    function set($model_id){
        $this->image = Images::find($model_id);
        $this->name = $this->image->name;
    }

    function update(){
        $this->validate();
        $this->image->update($this->all());
    }

    function delete(){
        // $this->image = Images::find($model_id);
        unlink($this->image->path);
        $this->image->delete();
    }
}

