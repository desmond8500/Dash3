<?php

namespace App\Livewire;

use Livewire\Component;

class TestPage extends Component
{
    public $number = 0;
    public $select;
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
    function alert_modal(){
        $this->dispatch('swal:modal',[
            'type' => 'success',
            'message' => 'User Created Successfully!',
            'text' => 'It will list on the users table soon.'
        ]);
    }


}
