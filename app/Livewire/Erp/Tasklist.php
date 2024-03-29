<?php

namespace App\Livewire\Erp;

use App\Livewire\Forms\TaskForm;
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
        ]);
    }

    public $active;
    #[On('get-tasks')]
    function getTasks() {
        if ($this->active) {
            if ($this->client_id) {
                return Task::orderBy('priority_id', 'desc')->where('client_id', $this->client_id)->finished($this->search)->paginate(4);
            }
            if ($this->projet_id) {
                return Task::orderBy('priority_id', 'desc')->where('projet_id', $this->projet_id)->finished($this->search)->paginate(4);
            }
            if ($this->building_id) {
                return Task::orderBy('priority_id', 'desc')->where('building_id', $this->building_id)->finished($this->search)->paginate(4);
            }
            if ($this->stage_id) {
                return Task::orderBy('priority_id', 'desc')->where('stage_id', $this->stage_id)->finished($this->search)->paginate(4);
            }
            if ($this->room_id) {
                return Task::orderBy('priority_id', 'desc')->where('room_id', $this->room_id)->finished($this->search)->orderBy('priority_id', 'desc')->paginate(4);
            }
            return Task::finished($this->search)->paginate(4);
        } else {
            if ($this->client_id) {
                return Task::orderBy('priority_id', 'desc')->where('client_id',$this->client_id)->active($this->search)->paginate(4);
            }
            if ($this->projet_id) {
                return Task::orderBy('priority_id', 'desc')->where('projet_id',$this->projet_id)->active($this->search)->paginate(4);
            }
            if ($this->building_id) {
                return Task::orderBy('priority_id', 'desc')->where('building_id',$this->building_id)->active($this->search)->paginate(4);
            }
            if ($this->stage_id) {
                return Task::orderBy('priority_id', 'desc')->where('stage_id',$this->stage_id)->active($this->search)->paginate(4);
            }
            if ($this->room_id) {
                return Task::orderBy('priority_id', 'desc')->where('room_id',$this->room_id)->active($this->search)->paginate(4);
            }
            return Task::orderBy('priority_id', 'desc')->active($this->search)->paginate(4);
        }

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
}
