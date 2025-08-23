<div class="card">
    <div class="card-body">
        <h3 class="card-title">{{ $title ?? 'Liste des taches' }}</h3>

        <div class="divide-y-2 ">
            @foreach ($tasks as $task)
                @if ($task->statut_id < 4)
                    @include('_card.task1_card',['task' => $task])
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

        <hr>
        <h3>Taches terminées</h3>
        @foreach ($tasks as $task)
            @if ($task->statut_id > 3)
                @include('_card.task1_card',['task' => $task])
            @endif
        @endforeach
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
