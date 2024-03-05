<div class="card p-2">
    <div class="row">

        <div  class="col">
            <div class="status status-blue" style="font-size: 12px;">
                @if ($task->client_id)
                    <a data-bs-toggle="tooltip" data-bs-placement="top" href="{{ route('projets',['client_id'=>$task->client->id]) }}" title="Client">{{ $task->client->name }}</a>
                @endif

                @if ($task->projet_id)
                    <a data-bs-toggle="tooltip" data-bs-placement="top" href="{{ route('projets',['client_id'=>$task->projet->client->id]) }}" title="Client">{{ $task->projet->client->name }}</a> /
                    <a data-bs-toggle="tooltip" data-bs-placement="top" href="{{ route('projet',['projet_id'=>$task->projet->id]) }}" title="Projet">{{ $task->projet->name }}</a>
                @endif

                @if ($task->building_id)
                    <a data-bs-toggle="tooltip" data-bs-placement="top" href="{{ route('projets',['client_id'=>$task->building->projet->client->id]) }}" title="Client">{{ $task->building->projet->client->name }}</a> /
                    <a data-bs-toggle="tooltip" data-bs-placement="top" href="{{ route('projet',['projet_id'=>$task->building->projet->id]) }}" title="Projet">{{ $task->building->projet->name }}</a> /
                    <a data-bs-toggle="tooltip" data-bs-placement="top" href="{{ route('building', ['building_id'=>$task->building->id]) }}" title="Batiment">{{ $task->building->name }}</a>
                @endif

                @if ($task->devis_id)
                    <a data-bs-toggle="tooltip" data-bs-placement="top" href="{{ route('projets',['client_id'=>$task->devis->projet->client->id]) }}" title="Client">{{ $task->devis->projet->client->name }}</a> /
                    <a data-bs-toggle="tooltip" data-bs-placement="top" href="{{ route('projet',['projet_id'=>$task->devis->projet->id]) }}" title="Projet">{{ $task->devis->projet->name }}</a> /
                    <a data-bs-toggle="tooltip" data-bs-placement="top" href="{{ route('invoice', ['invoice_id'=>$task->devis->id]) }}" title="Devis">{{ $task->devis->reference }}</a>
                @endif

                @if ($task->stage_id)
                    <a data-bs-toggle="tooltip" data-bs-placement="top" href="{{ route('projets',['client_id'=>$task->stage->building->projet->client->id]) }}" title="Client">{{ $task->stage->building->projet->client->name }}</a> /
                    <a data-bs-toggle="tooltip" data-bs-placement="top" href="{{ route('projet',['projet_id'=>$task->stage->building->projet->id]) }}" title="Projet">{{ $task->stage->building->projet->name }}</a> /
                    <a data-bs-toggle="tooltip" data-bs-placement="top" href="{{ route('building', ['building_id'=>$task->stage->building->id]) }}" title="Batiment">{{ $task->stage->building->name }}</a> /
                    <a data-bs-toggle="tooltip" data-bs-placement="top" href="{{ route('stage', ['stage_id'=>$task->stage->id]) }}" title="Niveau">{{ $task->stage->name }}</a>
                @endif

                @if ($task->room_id)
                    <a data-bs-toggle="tooltip" data-bs-placement="top" href="{{ route('projets',['client_id'=>$task->room->stage->building->projet->client->id]) }}" title="Client">{{ $task->room->stage->building->projet->client->name }}</a> /
                    <a data-bs-toggle="tooltip" data-bs-placement="top" href="{{ route('projet',['projet_id'=>$task->room->stage->building->projet->id]) }}" title="Projet">{{ $task->room->stage->building->projet->name }}</a> /
                    <a data-bs-toggle="tooltip" data-bs-placement="top" href="{{ route('building', ['building_id'=>$task->room->stage->building->id]) }}" title="Batiment">{{ $task->room->stage->building->name }}</a> /
                    <a data-bs-toggle="tooltip" data-bs-placement="top" href="{{ route('stage', ['stage_id'=>$task->room->stage->id]) }}" title="Niveau">{{ $task->room->stage->name }}</a> /
                    <a data-bs-toggle="tooltip" data-bs-placement="top" href="{{ route('room', ['room_id'=>$task->room->id]) }}" title="Local">{{ $task->room->name }}/</a>
                @endif
            </div>
            <a href="{{ route('task', ['task_id'=> $task->id]) }}" class="pl-2">
                <div class="fw-bold">{{ $task->name }}</div>
                <div class="text-muted">{!! nl2br($task->description) !!}</div>
            </a>
        </div>
        <div class="col-auto text-end">
            <div class="mb-1">
                <button class="btn btn-outline-primary btn-icon" wire:click="edit('{{ $task->id }}')">
                    <i class="ti ti-edit"></i>
                </button>
            </div>

            <div class="badge badge-pill mb-1
                    @if($task->priority_id ==1) bg-primary  @endif
                    @if($task->priority_id ==2) bg-warning  @endif
                    @if($task->priority_id ==3) bg-danger  @endif
                "> {{ $task->priority->name }}
            </div>

            <div>
                <span class="badge badge-pill mb-1
                    @if($task->statut_id ==1) bg-primary  @endif
                    @if($task->statut_id ==2) bg-warning  @endif
                    @if($task->statut_id ==3) bg-secondary @endif
                    @if($task->statut_id ==4) bg-success  @endif
                ">{{ $task->statut->name }}</span>
            </div>
        </div>
    </div>
</div>
