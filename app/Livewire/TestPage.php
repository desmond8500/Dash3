<?php

namespace App\Livewire;

use Livewire\Component;

class TestPage extends Component
{
    public $number = 0;
    public $modal = "addModal";

    public function render()
    {
        return view('livewire.test-page');
    }

    function open() {
        $this->dispatch('open-modal');
    }

    function close() {
        $this->dispatch('close-addModal');
    }
    function close2() {
        $this->dispatch('close-modal');
    }

    function incf(){
        $this->number++;
    }


}
