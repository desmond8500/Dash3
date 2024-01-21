<?php

namespace App\Livewire;

use App\Models\TaskPriority;
use App\Models\TaskStatus;
use App\Models\User;
use Livewire\Component;

class SettingsPage extends Component
{
    public function render()
    {
        return view('livewire.settings-page',[
            'user' => auth()->user(),
            'users' => User::all(),
            'taskPriorities' => TaskPriority::all(),
            'taskStatuses' => TaskStatus::all(),
        ]);
    }

    public $tab = 0;
}
