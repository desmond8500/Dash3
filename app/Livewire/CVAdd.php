<?php

namespace App\Livewire;

use App\Livewire\Forms\CVForm;
use Livewire\Component;

class CVAdd extends Component
{
    public $user_id;

    function mount($user_id){
        $this->user_id = $user_id;
    }

    public function render()
    {
        return view('livewire.c-v-add');
    }

    public CVForm $cv_form;

    function store(){
        $this->cv_form->user_id = $this->user_id;
        $this->cv_form->store();
        $this->dispatch('close-addCV');
        $this->dispatch('get-cv');
    }
}
