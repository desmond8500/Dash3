<div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">Liste des taches</div>
            <div class="card-actions">
                @livewire('form.task-add', )
            </div>
        </div>
        <div class="p-2">
            <div class="input-icon">
                <input type="text" placeholder="Trouver une tache" class="form-control form-control-rounded mb-2 border" wire:model.live='search'>
                <span class="input-icon-addon">
                    <i class="ti ti-search"></i>
                </span>
            </div>
            @foreach ($tasks as $task)
                <div class="mb-2">
                    @include('_card.task_card')
                    {{-- @livewire('task.task-card', ['task' => $task], key($task->id)) --}}
                </div>
            @endforeach
        </div>
        <div class="card-footer">
            {{ $tasks->links() }}
        </div>
    </div>

    @component('components.modal', ["id"=>'editTaskModal', 'title' => 'Editer une tache'])
        <form class="row" wire:submit="update">
            @include('_form.task_form')

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-editTaskModal', event => { $('#editTaskModal').modal('show'); }) </script>
        <script> window.addEventListener('close-editTaskModal', event => { $('#editTaskModal').modal('hide'); }) </script>
    @endcomponent




</div>
