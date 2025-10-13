<?php

namespace App\Livewire;

use Livewire\Component;

class MyprojectPage extends Component
{
    public $project_id;

    function mount($project_id){
        $this->project_id = $project_id;
    }

    public function render()
    {
        return view('livewire.myproject-page',[
            'project' => \App\Models\Myproject::find($this->project_id),
        ]);
    }
}
