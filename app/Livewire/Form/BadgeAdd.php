<?php

namespace App\Livewire\Form;

use App\Livewire\Forms\BadgeForm;
use Livewire\Component;

class BadgeAdd extends Component
{
    public $projet_id;
    public BadgeForm $badge_form;

    function mount($projet_id){
        $this->projet_id = $projet_id;
        $this->badge_form->projet_id = $projet_id;
    }

    public function render()
    {
        return view('livewire.form.badge-add');
    }

    function store()
    {
        $this->badge_form->store();
        $this->dispatch('close-addbadge');
    }
}
