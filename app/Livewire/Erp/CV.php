<?php

namespace App\Livewire\Erp;

use App\Models\CV as ModelsCV;
use Livewire\Attributes\On;
use Livewire\Component;

class CV extends Component
{
public $user_id;

function mount($user_id){
    $this->user_id = $user_id;
}
    #[On('get-cv')]
    public function render()
    {
        return view('livewire.erp.c-v',[
            'cvs' => ModelsCV::where('user_id', $this->user_id)->get(),
        ]);
    }
}
