<?php

namespace App\Livewire\Settings;

use App\Models\TaskPriority;
use App\Models\TaskStatus;
use Livewire\Component;

class TaskStatusList extends Component
{
    public function render()
    {
        return view('livewire.settings.task-status-list',[
            'taskPriorities' => TaskPriority::all(),
            'taskStatuses' => TaskStatus::all(),
        ]);
    }
}
