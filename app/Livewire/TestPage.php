<?php

namespace App\Livewire;

use Livewire\Component;

class TestPage extends Component
{
    public $number = 0;

    public function render()
    {
        return view('livewire.test-page');
    }

    function open() {
        $this->dispatch('open-modal');
    }

    function close() {
        $this->dispatch('close-modal');
    }
    function close2() {
        $this->dispatch('close-modal');
    }

    function incf(){
        $this->number++;
    }


}
