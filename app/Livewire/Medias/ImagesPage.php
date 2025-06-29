<?php

namespace App\Livewire\Medias;

use App\Livewire\Forms\ImageForm;
use App\Models\Images;
use Livewire\Attributes\Session;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ImagesPage extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $search = '';
    public $breadcrumbs;
    #[Session()]
    public $selected_image;

    function select_image($image_id)
    {
        $image = Images::find($image_id);
        $this->selected_image = $image;
    }

    function delete()
    {
        if ($this->selected_image) {
            $this->selected_image->delete();
            $this->dispatch('close-image-details');
        }
    }

    public function mount()
    {
        $this->breadcrumbs = array(
            array('name' => 'Medias', 'route' => ''),
            array('name' => 'Images', 'route' => ''),
        );
    }

    public function render()
    {
        return view('livewire.medias.images-page',[
            'images' => Images::paginate(12),
        ]);
    }

    // Images
    public ImageForm $form;

    function store(){
        $this->form->store();
        $this->dispatch('close-addImages');
    }

    // Tags
    function addTag(){
        if ($this->selected_image) {
            $this->selected_image->attachTag($this->form->name);
            $this->dispatch('close-image-details');
        }
    }
}
