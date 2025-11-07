<?php

namespace App\Livewire\Forms;

use App\Models\Video;
use Illuminate\Container\Attributes\Storage;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class VideoForm extends Form
{
    use WithFileUploads;
    use WithPagination;

    public Video $video;

    #[Rule('required')]
    public $title;
    public $description;
    public $url;
    public $folder;
    public $preview_image;

    function fix(){
        $this->title = ucfirst($this->title);
    }


    function store(){
        // $this->validate();
        $video = Video::create($this->all());

        $this->storeAvatar($video, $this->preview_image);


    }

    function set($model_id){
        $this->video = Video::find($model_id);
        $this->title = $this->video->title;
        $this->description = $this->video->description;
        $this->url = $this->video->url;
        $this->folder = $this->video->folder;
        $this->preview_image = $this->video->preview_image;

    }

    function update(){
        $this->validate();
        $this->video->update($this->all());
    }

    function delete($model_id){
        $this->video = Video::find($model_id);

        // unlink(this->video->path);
        // rmdir(dirname(this->video->path));

        $this->video->delete();
    }


    function storeAvatar($video, $image, $delete = false){
        if (!is_string($image)) {
            $dir = "medias/videos/$video->id/avatar";
            if ($delete) {
                Storage::disk('public')->deleteDirectory($dir);
            }
            $name = $image->getClientOriginalName();
            $image->storeAs("public/$dir", $name);

            $video->preview_image = "storage/$dir/$name";
            $video->save();
        }
    }



}
