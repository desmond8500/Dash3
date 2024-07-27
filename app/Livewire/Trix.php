<?php

namespace App\Livewire;

use Livewire\Attributes\Js;
use Livewire\Component;

class Trix extends Component
{
    /**
     * @param Type content
    */
    public $content;

    function mount($content){
        $this->content = $content;
    }

    public function render()
    {
        return view('livewire.trix');
    }

    function save(){
    }


}
