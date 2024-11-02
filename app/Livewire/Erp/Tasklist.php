<?php

namespace App\Livewire\Erp;

use App\Http\Controllers\TaskController;
use App\Livewire\Forms\SubtaskForm;
use App\Livewire\Forms\TaskForm;
use App\Models\Client;
use App\Models\Projet;
use App\Models\Subtask;
use App\Models\Task;
use App\Models\TaskPriority;
use App\Models\TaskStatus;
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

    public $client_id;
    public $projet_id;
    public $building_id;
    public $stage_id;
    public $room_id;
    public $task;

    public function mount($client_id=null, $projet_id = null, $building_id = null, $stage_id = null, $room_id = null){

        if ($client_id) {
            $this->client_id = $client_id;
        }
        if ($projet_id) {
            $this->projet_id = $projet_id;
        }
        if ($building_id) {
            $this->building_id = $building_id;
        }
        if ($stage_id) {
            $this->stage_id = $stage_id;
        }
        if ($room_id) {
            $this->room_id = $room_id;
        }
    }

    public function render()
    {
        return view('livewire.erp.tasklist',[
            'tasks' => $this->getTasks(),
            'activeCount' => Task::activeCount(),
            'inactiveCount' => Task::inactiveCount(),
            'statuses' => TaskStatus::all(),
            'priorities' => TaskPriority::all(),

            'clients' => Client::all(),
            'projets' => Projet::all(),
            // 'projets' => Projet::all(),
            // 'subtasks' => $this->getSubtasks()
        ]);
    }

    public $active;
    #[On('get-tasks')]
    function getTasks() {
       return TaskController::getTask($this->active, $this->client_id, $this->projet_id, $this->building_id, $this->stage_id, $this->room_id, $this->search);
    }

    public TaskForm $form;

    #[On('task-edit')]
    function edit($task_id){
        $this->form->set($task_id);
        $this->dispatch('open-editTaskModal');
    }

    function show($task_id){
        $this->form->set($task_id);
        $this->task = Task::find($task_id);
        $this->subtasks = $this->getSubtasks($task_id);
        $this->dispatch('open-taskDetail');
    }

    function update(){
        $this->form->update();
        $this->dispatch('close-editTaskModal');
    }

    function toggleFavorite()
    {
        $this->form->favoris();
    }

    function tasklist_pdf(){
        return redirect()->route('tasks_pdf',['tasks'=> 12]);
    }

    function delete(){
        $this->form->delete();
        $this->dispatch('close-editTaskModal');
    }

    // Subtask
    public $show_subtask_bool = false;
    public SubtaskForm $subtask_form;
    public $subtasks = [];

    function show_subtask_form($value){
        $this->show_subtask_bool = $value;
    }

    function subtask_store(){
        $this->subtask_form->task_id = $this->form->id;
        $this->subtask_form->order = Subtask::where('task_id', $this->form->id)->count() + 1;
        $this->subtask_form->store();
        $this->show_subtask_form(false);
        $this->dispatch('get-subtasks');
    }

    function subtask_edit($id){
        $this->subtask_form->set($id);
    }

    function subtask_update(){
        $this->subtask_form->update();
        $this->dispatch('get-subtasks');
    }

    function subtask_delete($id){
        $this->subtask_form->delete($id);
        $this->dispatch('get-subtasks');
    }

    #[On('get-subtasks')]
    function getSubtasks($task_id){
        return Subtask::where('task_id',$task_id)->get();
    }
}
