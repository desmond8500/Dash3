<?php

namespace App\Livewire\Medias;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ImagesPage extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $search = '';
    public $breadcrumbs;

    public function mount()
    {
        $this->breadcrumbs = array(
            array('name' => 'Medias', 'route' => ''),
            array('name' => 'Images', 'route' => ''),
        );
    }

    public function render()
    {
        return view('livewire.medias.images-page');
    }
}
