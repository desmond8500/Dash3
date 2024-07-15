<?php

namespace App\Livewire;

use App\Livewire\Forms\BadgeForm;
use App\Models\Badge;
use Livewire\Component;

class Badges extends Component
{
    public $projet_id;
    public BadgeForm $badge_form;

    function mount($projet_id)
    {
        $this->projet_id = $projet_id;
    }
    public function render()
    {
        return view('livewire.badges',[
            'badges' => Badge::where('projet_id', $this->projet_id)->get(),
        ]);
    }

    function store(){
        $this->badge_form->store();
    }
}
