<?php

namespace App\Livewire\Modal;

use LivewireUI\Modal\ModalComponent;

class RegisterModal extends ModalComponent
{
    public function render()
    {
        return view('livewire.modal.register-modal');
    }
}
