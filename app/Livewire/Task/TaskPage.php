<?php

namespace App\Livewire\Task;

use App\Livewire\Forms\TaskForm;
use App\Models\Task;
use App\Models\TaskPriority;
use App\Models\TaskStatus;
use Livewire\Component;

class TaskPage extends Component
{
    public TaskForm $form;
    public $task;

    function mount($task_id)
    {
        $this->task = Task::find($task_id);

        $this->form->set($task_id);

    }

    public function render()
    {
        return view('livewire.task.task-page',[
            'statuses' => TaskStatus::all(),
            'priorities' => TaskPriority::all(),
        ]);
    }

    public function update()
    {
        $this->task = $this->form->update();
       $this->dispatch('close-editTaskModal');
    }



}
