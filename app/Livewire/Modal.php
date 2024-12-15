<?php

namespace App\Livewire;

use Livewire\Component;

class Modal extends Component
{
    protected $listeners = ['openModal'];

    public function render()
    {
        return view('livewire.modal');
    }

    public $isOpen = false;

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

}
