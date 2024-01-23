<div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">Liste des taches</div>
            <div class="card-actions">
                @livewire('form.task-add', )
            </div>
        </div>
        <div class="p-2">
            @foreach ($tasks as $task)
                <div class="mb-2">
                    @livewire('task.task-card', ['task' => $task], key($task->id))
                </div>
            @endforeach
        </div>
        <div class="card-footer">
            {{ $tasks->links() }}
        </div>
    </div>

    @component('components.modal', ["id"=>'editTaskModal', 'title' => 'Editer une tache 1'.$task->id])
        <form class="row" wire:submit="updateTask">

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-editTaskModal', event => { $('#editTaskModal').modal('show'); }) </script>
        <script> window.addEventListener('close-editTaskModal', event => { $('#editTaskModal').modal('hide'); }) </script>
    @endcomponent




</div>
