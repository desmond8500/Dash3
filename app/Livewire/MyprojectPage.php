<?php

namespace App\Livewire;

use Livewire\Component;

class MyprojectPage extends Component
{
    public $project_id;
    public $breadcrumbs = '';

    function mount($project_id){
        $this->project_id = $project_id;
        $projet = \App\Models\Myproject::find($project_id);
        $this->breadcrumbs = array(
            array('name' => 'Mes Projets', 'route' => route('myprojects')),
            array('name' => $projet->name , 'route' => ''),
        );
    }

    public function render()
    {
        return view('livewire.myproject-page',[
            'project' => \App\Models\Myproject::find($this->project_id),
        ]);
    }
}
