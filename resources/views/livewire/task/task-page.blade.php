<div>
    @component('components.layouts.page-header', ['title'=> 'Tache'])

    @endcomponent

    <div class="row">
        <div class="col-md-4">

            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{ $task->name }}</div>
                    <div class="card-actions">
                        <button class="btn btn-primary btn-icon" wire:click="dispatch('open-editTaskModal')">
                            <i class="ti ti-edit"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    {{ nl2br($task->description) }}
                </div>
                <!-- Some borders are removed -->
                <ul class="list-group list-group-flush">
                    @if ($task->client_id) <li class="list-group-item"><span>Client :</span> {{ $task->client->name }}</li> @endif
                    @if ($task->projet_id) <li class="list-group-item"><span>projet :</span> {{ $task->client }}</li> @endif
                    @if ($task->building_id) <li class="list-group-item"><span>building :</span> {{ $task->client }}</li> @endif
                    @if ($task->stage_id) <li class="list-group-item"><span>stage :</span> {{ $task->client }}</li> @endif
                    @if ($task->room_id) <li class="list-group-item"><span>room :</span> {{ $task->client }}</li> @endif

                </ul>


                <div class="card-footer">

                </div>
            </div>

        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Détails de la tache</div>
                    <div class="card-actions">

                    </div>
                </div>
                <div class="card-body">

                </div>
                <div class="card-footer">

                </div>
            </div>
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
