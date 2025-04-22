<div class="card p-2">
    <div class="row">

        <div  class="col">

            <div class="d-none d-sm-block">
                <div class="dropdown open">
                    <button class="btn btn-action" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                        <i class="ti ti-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="triggerId">
                        @if ($task->client_id)
                            <a class="dropdown-item " href="{{ route('projets',['client_id'=>$task->client->id]) }}" title="Client">
                                Client - <span class="status status-blue">{{ $task->client->name }}</span>
                            </a>
                        @endif
                        @if ($task->projet_id)
                            <a class="dropdown-item" href="{{ route('projet',['projet_id'=>$task->projet->id]) }}" title="Projet">
                                Projet - <span class="status status-blue"> {{ $task->projet->name }} </span>
                            </a>
                        @endif
                        @if ($task->building_id)
                            <a class="dropdown-item" href="{{ route('building', ['building_id'=>$task->building->id]) }}" title="Batiment">
                               Batiment - <span class="status status-blue"> {{ $task->building->name }} </span>
                            </a>
                        @endif
                        @if ($task->devis_id)
                            <a class="dropdown-item" href="{{ route('invoice', ['invoice_id'=>$task->devis->id]) }}" title="Devis">
                                Batiment - <span class="status status-blue"> {{ $task->devis->reference }} </span>
                            </a>
                        @endif
                        @if ($task->stage_id)
                            <a class="dropdown-item" href="{{ route('stage', ['stage_id'=>$task->stage->id]) }}" title="Niveau">
                                Niveau - <span class="status status-blue"> {{ $task->stage->name }} </span>
                            </a>
                        @endif
                        @if ($task->room_id)
                            <a class="dropdown-item" href="{{ route('room', ['room_id'=>$task->room->id]) }}" title="Local">
                                Local - <span class="status status-blue"> {{ $task->room->name }} </span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="status status-blue d-block d-sm-none" style="font-size: 12px;">
                @if ($task->client_id)
                    <a data-bs-toggle="tooltip" data-bs-placement="top" href="{{ route('projets',['client_id'=>$task->client->id]) }}" title="Client">{{ $task->client->name }}</a>
                @endif

                @if ($task->projet_id)
                    @if ($task->client_id) / @endif
                    <a data-bs-toggle="tooltip" data-bs-placement="top" href="{{ route('projet',['projet_id'=>$task->projet->id]) }}" title="Projet">{{ $task->projet->name }}</a>
                @endif

                @if ($task->building_id)/
                    <a data-bs-toggle="tooltip" data-bs-placement="top" href="{{ route('building', ['building_id'=>$task->building->id]) }}" title="Batiment">{{ $task->building->name }}</a>
                @endif

                @if ($task->devis_id)/
                    <a data-bs-toggle="tooltip" data-bs-placement="top" href="{{ route('invoice', ['invoice_id'=>$task->devis->id]) }}" title="Devis">{{ $task->devis->reference }}</a>
                @endif

                @if ($task->stage_id)/
                    <a data-bs-toggle="tooltip" data-bs-placement="top" href="{{ route('stage', ['stage_id'=>$task->stage->id]) }}" title="Niveau">{{ $task->stage->name }}</a>
                @endif

                @if ($task->room_id)/
                    <a data-bs-toggle="tooltip" data-bs-placement="top" href="{{ route('room', ['room_id'=>$task->room->id]) }}" title="Local">{{ $task->room->name }}</a>
                @endif
            </div>
            <a href="{{ route('task', ['task_id'=> $task->id]) }}" class="pl-2">
                <div class="fw-bold">{{ $task->name }}</div>
                <div class="text-muted">@parsedown($task->description)</div>
            </a>
        </div>
        <div class="col-auto text-end">
            <div class="mb-2">
                <button class="btn btn-sm btn-icon btn-outline-primary rounded p-1" wire:click="edit('{{ $task->id }}')">
                    <i class="ti ti-edit"></i>
                </button>
                <button class="btn btn-sm btn-icon btn-outline-primary rounded p-1" wire:click="show('{{ $task->id }}')">
                    <i class="ti ti-eye"></i>
                </button>

            </div>

            <div class="badge badge-pill text-white mb-1
                    @if($task->priority_id ==1) bg-primary  @endif
                    @if($task->priority_id ==2) bg-warning  @endif
                    @if($task->priority_id ==3) bg-danger  @endif
                "> {{ $task->priority->name }}
            </div>

            <div>
                <span class="badge badge-pill text-white mb-1
                    @if($task->statut_id ==1) bg-primary  @endif
                    @if($task->statut_id ==2) bg-warning  @endif
                    @if($task->statut_id ==3) bg-secondary @endif
                    @if($task->statut_id ==4) bg-success  @endif
                ">{{ $task->statut->name }}</span>
            </div>
        </div>
    </div>
</div>
