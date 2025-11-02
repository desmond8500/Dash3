<?php

use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Livewire\Forms\SubtaskForm;
use App\Livewire\Forms\TaskForm;
use App\Http\Controllers\TaskController;
use App\Models\TaskStatus;
use App\Models\TaskPriority;

new class extends Component {
    use WithPagination;
    use WithFileUploads;

    public TaskForm $form;

    public $client_id;
    public $projet_id;
    public $building_id;
    public $stage_id;
    public $room_id;
    public $journal_id;

    public $search;
    public $paginate;
    public $toggle = true;

    protected $listeners = ['get-tasks' => 'render'];

    public function mount($client_id = null, $projet_id = null, $building_id = null, $stage_id = null, $room_id = null, $journal_id = null)
    {
        if ($client_id) {
            $this->client_id = $client_id;
            $this->form->client_id = $client_id;
        }
        if ($projet_id) {
            $this->projet_id = $projet_id;
            $this->form->projet_id = $projet_id;
        }
        if ($building_id) {
            $this->building_id = $building_id;
            $this->form->building_id = $building_id;
        }
        if ($stage_id) {
            $this->stage_id = $stage_id;
            $this->form->stage_id = $stage_id;
        }
        if ($room_id) {
            $this->room_id = $room_id;
            $this->form->room_id = $room_id;
        }
        if ($journal_id) {
            $this->journal_id = $journal_id;
            $this->form->journal_id = $journal_id;
        }

    }

    function with(): array
    {
        return [
            'tasks' => $this->get_active_tasks(),
            'tasks_active' => $this->get_active_tasks(),
            'tasks_finisehd' => $this->get_finished_tasks(),
            'statuses' => TaskStatus::all(),
            'priorities' => TaskPriority::all(),
        ];
    }

    function getTasks()
    {
        return TaskController::getTask($this->active, $this->client_id, $this->projet_id, $this->building_id, $this->stage_id,
        $this->room_id, $this->journal_id, $this->search, $this->paginate);
    }
    function get_active_tasks()
    {
        return TaskController::getTask(false, $this->client_id, $this->projet_id, $this->building_id, $this->stage_id,
        $this->room_id, $this->journal_id, $this->search, $this->paginate);
    }
    function get_finished_tasks()
    {
        return TaskController::getTask(false, $this->client_id, $this->projet_id, $this->building_id, $this->stage_id,
        $this->room_id, $this->journal_id, $this->search, $this->paginate);
    }

    function store()
    {
        $this->form->store();
        $this->dispatch('close-addTask');
        $this->dispatch('get-tasks');
    }

    function edit($task_id) {
        $this->form->set($task_id);
        $this->dispatch('open-editTaskModal');
    }

    function show($task_id) {
        $this->form->set($task_id);
        $this->task = Task::find($task_id);
        $this->subtasks = $this->getSubtasks($task_id);
        $this->dispatch('open-taskDetail');
    }

    function update()
    {
        $this->form->update();
        $this->dispatch('close-editTaskModal');
    }

    function delete($task_id)
    {
        $this->form->delete($task_id);
        $this->dispatch('close-editTaskModal');
    }
}; ?>

<div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $title ?? 'Liste des taches' }}</h3>
            <div class="card-actions">
                @if ($toggle)
                    <button class="btn btn-primary" wire:click="$toggle('toggle')">Terminés</button>
                @else
                <button class="btn btn-primary" wire:click="$toggle('toggle')">En cours</button>
                @endif
            </div>
        </div>
        <div class="card-body">
            @if ($toggle)
                <div class="divide-y-2 ">
                    @foreach ($tasks_active as $task)
                        @if ($task->statut_id < 4) @include('_card.task1_card',['task'=> $task])
                        @endif
                    @endforeach

                    <div class="d-flex align-items-center">
                        <i class="ti ti-plus"></i>
                        <input type="text" class="form-control form-control-flush" wire:model="form.name" placeholder="Ajouter une tâche" wire:keydown.enter="store">
                    </div>
                </div>
                <div class="mt-3">
                    {{ $tasks->links() }}
                </div>

            @else
                <h3>Taches terminées</h3>
                @foreach ($tasks_finisehd as $task)
                    @if ($task->statut_id > 3)
                        @include('_card.task1_card',['task' => $task])
                    @endif
                @endforeach
            @endif

        </div>

        @component('components.modal', ["id"=>'editTaskModal', 'title' => 'Editer une tache'])
            <form class="row" wire:submit="update">
                @include('_form.task_form')

                <div class="d-flex-between">
                    <a type="button" class="btn btn-danger" wire:click='delete()'>
                        <i class="ti ti-trash"></i>
                    </a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Valider</button>
                </div>
            </form>
            <script> window.addEventListener('open-editTaskModal', event => { window.$('#editTaskModal').modal('show'); }) </script>
            <script> window.addEventListener('close-editTaskModal', event => { window.$('#editTaskModal').modal('hide'); }) </script>
        @endcomponent
</div>
