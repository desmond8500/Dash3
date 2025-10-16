<?php

namespace App\Livewire;

use App\Livewire\Forms\MyprojectForm;
use App\Models\Myproject;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithPagination;

class MyprojectsPage extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $listeners = ['get_my_projects'];
    public $search = '';
    public MyprojectForm $project_form;

    public $breadcrumbs = '';
    public function mount(){
        $this->breadcrumbs = array(
            array('name' => 'Mes Projets', 'route' => route('myprojects')),
        );
    }

    public function render()
    {
        return view('livewire.myprojects-page',[
            'projects' => $this->get_my_projects(),
        ]);
    }


    #[On('get_my_projects')]
    function get_my_projects()
    {
        return Myproject::search($this->search)->paginate(20);
    }

    #[On('editProject')]
    function edit_project($project_id)
    {
        $this->project_form->set($project_id);
        $this->dispatch('open-editProject');
    }
    function update()
    {
        $this->project_form->update();
        $this->dispatch('close-editProject');
        $this->dispatch('get_my_projects');
    }


}
