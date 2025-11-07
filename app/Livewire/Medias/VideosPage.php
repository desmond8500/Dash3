<?php

namespace App\Livewire\Medias;

use App\Livewire\Forms\VideoForm;
use App\Models\Video;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class VideosPage extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $search = '';
    public $breadcrumbs;

    public VideoForm $video_form;

    public function mount()
    {
        $this->breadcrumbs = array(
            array('name' => 'Medias', 'route' => ''),
            array('name' => 'Videos', 'route' => 'videos'),
        );
    }

    public function render()
    {
        return view('livewire.medias.videos-page',[
            'videos' => $this->getVideos(),
        ]);
    }

    #On('get-videos')
    function getVideos(){
        return Video::where('title', 'like', '%' . $this->search . '%')->paginate(10);
    }

    #On('open-editVideo')
    function edit($video_id){
        $this->video_form->set($video_id);
        $this->dispatch('open-editVideo');
    }

    function update(){
        $this->video_form->update();
        $this->dispatch('close-editVideo');
        $this->dispatch('get-videos');
    }

    function delete($model_id){
        $video = Video::find($model_id);

        // unlink(this->video->path);
        // rmdir(dirname(this->video->path));

        $video->delete();
        $this->dispatch('get-videos');
    }
}
