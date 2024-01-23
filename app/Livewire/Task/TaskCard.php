<?php

namespace App\Livewire\Task;

use App\Models\TaskPriority;
use App\Models\TaskStatus;
use Livewire\Component;

class TaskCard extends Component
{
    public $task;

    function mount($task) {
        $this->task = $task;
    }

    public function render()
    {
        return view('livewire.task.task-card',[

        ]);
    }

    function edit(){
        $this->dispatch('edit-task');
    }
}
