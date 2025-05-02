<div>
    <div class="card">
        <div class="card-header">
            <a class="card-title" href="{{ route('tasks') }}">Liste des taches
                @if ($active)
                    terminés
                @else
                    en cours
                @endif
            </a>
            <div class="card-actions">
                <div class="d-block d-sm-none">
                    <div class="dropdown open">
                        <button class="btn btn-action" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                            <i class="ti ti-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="triggerId">
                            @if ($client_id)
                            <a class="dropdown-item"
                                href="{{ route('tasks_pdf',['id'=>$client_id, 'type'=>'client_id', 'search'=>$search]) }}" target="_blank">
                                <i class="ti ti-file-type-pdf"></i> Exporter en PDF
                            </a>
                            @elseif($projet_id)
                            <a class="dropdown-item"
                                href="{{ route('tasks_pdf',['id'=>$projet_id, 'type'=>'projet_id', 'search'=>$search]) }}" target="_blank">
                                <i class="ti ti-file-type-pdf"></i> Exporter en PDF
                            </a>
                            @elseif($building_id)
                            <a class="dropdown-item"
                                href="{{ route('tasks_pdf',['id'=>$building_id, 'type'=>'building_id', 'search'=>$search]) }}" target="_blank">
                                <i class="ti ti-file-type-pdf"></i> Exporter en PDF
                            </a>
                            @elseif($stage_id)
                            <a class="dropdown-item"
                                href="{{ route('tasks_pdf',['id'=>$stage_id, 'type'=>'stage_id', 'search'=>$search]) }}" target="_blank">
                                <i class="ti ti-file-type-pdf"></i> Exporter en PDF
                            </a>
                            @elseif($room_id)
                            <a class="dropdown-item"
                                href="{{ route('tasks_pdf',['id'=>$room_id, 'type'=>'room_id', 'search'=>$search]) }}" target="_blank">
                                <i class="ti ti-file-type-pdf"></i> Exporter en PDF
                            </a>
                            @endif

                            <a class="dropdown-item" wire:click="$toggle('active')">
                                <i class="ti ti-circle"></i>
                                @if ($active)
                                En cours {{ $activeCount }}
                                @else
                                Terminés {{ $inactiveCount }}
                                @endif
                            </a>
                        </div>
                    </div>

                </div>

                <div class="d-none d-sm-block">
                    <div class="btn-list">
                        @if ($client_id)
                        <a class="btn btn-primary btn-icon"
                            href="{{ route('tasks_pdf',['id'=>$client_id, 'type'=>'client_id', 'search'=>$search]) }}" target="_blank">
                            <i class="ti ti-file-type-pdf"></i>
                        </a>
                        @elseif($projet_id)
                        <a class="btn btn-primary btn-icon"
                            href="{{ route('tasks_pdf',['id'=>$projet_id, 'type'=>'projet_id', 'search'=>$search]) }}" target="_blank">
                            <i class="ti ti-file-type-pdf"></i>
                        </a>
                        @elseif($building_id)
                        <a class="btn btn-primary btn-icon"
                            href="{{ route('tasks_pdf',['id'=>$building_id, 'type'=>'building_id', 'search'=>$search]) }}" target="_blank">
                            <i class="ti ti-file-type-pdf"></i>
                        </a>
                        @elseif($stage_id)
                        <a class="btn btn-primary btn-icon"
                            href="{{ route('tasks_pdf',['id'=>$stage_id, 'type'=>'stage_id', 'search'=>$search]) }}" target="_blank">
                            <i class="ti ti-file-type-pdf"></i>
                        </a>
                        @elseif($room_id)
                        <a class="btn btn-primary btn-icon"
                            href="{{ route('tasks_pdf',['id'=>$room_id, 'type'=>'room_id', 'search'=>$search]) }}" target="_blank">
                            <i class="ti ti-file-type-pdf"></i>
                        </a>
                        @endif
                        <button class="btn btn-primary" wire:click="$toggle('active')">
                            @if ($active)
                            En cours {{ $activeCount }}
                            @else
                            Terminés {{ $inactiveCount }}
                            @endif
                        </button>
                        <button class="btn btn-icon" wire:click='$refresh'><i class="ti ti-reload"></i> </button>
                    </div>
                </div>

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
                    <div class="{{ $class ?? 'col-md-6'}}">
                        @include('_card.task_card',['task' => $task])
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

            <div class="d-flex-between">
                <a type="button" class="btn btn-danger"  wire:click='delete()'>
                    <i class="ti ti-trash"></i>
                </a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-editTaskModal', event => { window.$('#editTaskModal').modal('show'); }) </script>
        <script> window.addEventListener('close-editTaskModal', event => { window.$('#editTaskModal').modal('hide'); }) </script>
    @endcomponent

    @component('components.modal.link-modal', ["id"=>'taskDetail', 'title' => 'Editer une tache', 'task'=>$task])
        @include('_form.task_detail')
        <script> window.addEventListener('open-taskDetail', event => { window.$('#taskDetail').modal('show'); }) </script>
        <script> window.addEventListener('close-taskDetail', event => { window.$('#taskDetail').modal('hide'); }) </script>
    @endcomponent

</div>
