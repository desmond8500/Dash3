<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class TestPage extends Component
{
    use WithFileUploads;

    public function render(){
        return view('livewire.test-page');
    }

    public $title;

    public function trix_save($content)
    {
       $this->title = $content;
    }

}
