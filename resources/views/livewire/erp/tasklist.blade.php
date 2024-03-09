<div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">Liste des taches
                @if ($active)
                    terminés
                @else
                    en cours
                @endif
            </div>
            <div class="card-actions">
                <button class="btn btn-primary" wire:click="$toggle('active')">
                    @if ($active)
                        En cours {{ $activeCount }}
                    @else
                        Terminés {{ $inactiveCount }}
                    @endif
                </button>
            </div>
        </div>
        <div class="p-2">
            <div class="input-icon">
                <input type="text" placeholder="Trouver une tache" class="form-control form-control-rounded mb-2 border" wire:model.live='search'>
                <span class="input-icon-addon">
                    <i class="ti ti-search"></i>
                </span>
            </div>
            <div class="row row-deck g-2">
                @foreach ($tasks as $task)
                    <div class="{{ $class ?? 'col-md-12' }}">
                        @include('_card.task_card')
                        {{-- @livewire('task.task-card', ['task' => $task], key($task->id)) --}}
                    </div>
                @endforeach
            </div>
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
