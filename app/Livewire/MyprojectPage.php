<?php

namespace App\Livewire;

use App\Livewire\Forms\MyprojectForm;
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

    public MyprojectForm $project_form;
    function edit_project()
    {
        $this->project_form->set($this->project_id);
        $this->dispatch('open-editProject');
    }
    function update()
    {
        $this->project_form->update();
        $this->dispatch('close-editProject');
        $this->dispatch('get_my_projects');
    }
}
