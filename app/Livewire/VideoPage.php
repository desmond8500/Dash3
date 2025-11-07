<?php

namespace App\Livewire;

use App\Livewire\Forms\VideoForm;
use App\Models\Video;
use Livewire\Component;
use Livewire\WithPagination;

class VideoPage extends Component
{
    use WithPagination;
    public $breadcrumbs;
    public $video_id;

    public function mount($video_id)
    {
        $this->video_id = $video_id;
        $this->breadcrumbs = array(
            array('name' => 'Medias', 'route' => ''),
            array('name' => 'Videos', 'route' => ''),
        );
    }

    public function render()
    {
        return view('livewire.video-page',[
            'video' => Video::find($this->video_id),
        ]);
    }
}
