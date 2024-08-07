<?php

namespace App\Livewire\Task;

use Livewire\Component;

class TasksPage extends Component
{

    public $breadcrumbs = array(
        array("name" => "Taches", "route" => "taches"),
    );

    public function render()
    {
        return view('livewire.task.tasks-page');
    }
}
