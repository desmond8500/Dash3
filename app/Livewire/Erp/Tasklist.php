<?php

namespace App\Livewire\Erp;

use App\Livewire\Forms\TaskForm;
use App\Models\Task;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Tasklist extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';
    public $search ='';
    public $breadcrumbs;

    public function mount(){
        $this->breadcrumbs = array(
            // array('name' => 'Clients', 'route' => route('tabler.clients')),
        );
    }

    // function ProjetSearch() {
    // return Projet::where('client_id', $this->client_id)->where('name', 'like', '%' . $this->search . '%')->paginate(10);
    // }

    public function render()
    {
        return view('livewire.erp.tasklist',[
            'tasks' => Task::orderBy('id', 'DESC')->paginate(10),
        ]);
    }

    #[On('close-addTask')]
    function getTasks() {
        return Task::orderBy('id', 'DESC')->paginate(10);
    }

    public TaskForm $task;

    #[On('task-edit')]
    function editForm($task_id){
        $this->task = Task::find($task_id);
        $this->dispatch('open-editTaskModal');
    }
}
