<div class="modal fade" id="{{ $id ?? 'exampleModal' }}" tabindex="-1" aria-labelledby="{{ $id ?? 'exampleModal' }}Label" aria-hidden="true" wire:ignore.self>
    <div class="{{ $class ?? 'modal-dialog' }} modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $id ?? 'exampleModal' }}Label">
                    @isset($task)
                        <div class="status status-blue" style="font-size: 12px;">

                            @if ($task->client_id)
                            <a data-bs-toggle="tooltip" data-bs-placement="top" href="{{ route('projets',['client_id'=>$task->client->id]) }}"
                                title="Client">{{ $task->client->name }}</a>
                            @endif

                            @if ($task->projet_id)
                            <a data-bs-toggle="tooltip" data-bs-placement="top"
                                href="{{ route('projets',['client_id'=>$task->projet->client->id]) }}" title="Client">{{
                                $task->projet->client->name }}</a> /
                            <a data-bs-toggle="tooltip" data-bs-placement="top" href="{{ route('projet',['projet_id'=>$task->projet->id]) }}"
                                title="Projet">{{ $task->projet->name }}</a>
                            @endif

                            @if ($task->building_id)
                            <a data-bs-toggle="tooltip" data-bs-placement="top"
                                href="{{ route('projets',['client_id'=>$task->building->projet->client->id]) }}" title="Client">{{
                                $task->building->projet->client->name }}</a> /
                            <a data-bs-toggle="tooltip" data-bs-placement="top"
                                href="{{ route('projet',['projet_id'=>$task->building->projet->id]) }}" title="Projet">{{
                                $task->building->projet->name }}</a> /
                            <a data-bs-toggle="tooltip" data-bs-placement="top"
                                href="{{ route('building', ['building_id'=>$task->building->id]) }}" title="Batiment">{{ $task->building->name
                                }}</a>
                            @endif

                            @if ($task->devis_id)
                            <a data-bs-toggle="tooltip" data-bs-placement="top"
                                href="{{ route('projets',['client_id'=>$task->devis->projet->client->id]) }}" title="Client">{{
                                $task->devis->projet->client->name }}</a> /
                            <a data-bs-toggle="tooltip" data-bs-placement="top"
                                href="{{ route('projet',['projet_id'=>$task->devis->projet->id]) }}" title="Projet">{{
                                $task->devis->projet->name }}</a> /
                            <a data-bs-toggle="tooltip" data-bs-placement="top" href="{{ route('invoice', ['invoice_id'=>$task->devis->id]) }}"
                                title="Devis">{{ $task->devis->reference }}</a>
                            @endif

                            @if ($task->stage_id)
                            <a data-bs-toggle="tooltip" data-bs-placement="top"
                                href="{{ route('projets',['client_id'=>$task->stage->building->projet->client->id]) }}" title="Client">{{
                                $task->stage->building->projet->client->name }}</a> /
                            <a data-bs-toggle="tooltip" data-bs-placement="top"
                                href="{{ route('projet',['projet_id'=>$task->stage->building->projet->id]) }}" title="Projet">{{
                                $task->stage->building->projet->name }}</a> /
                            <a data-bs-toggle="tooltip" data-bs-placement="top"
                                href="{{ route('building', ['building_id'=>$task->stage->building->id]) }}" title="Batiment">{{
                                $task->stage->building->name }}</a> /
                            <a data-bs-toggle="tooltip" data-bs-placement="top" href="{{ route('stage', ['stage_id'=>$task->stage->id]) }}"
                                title="Niveau">{{ $task->stage->name }}</a>
                            @endif

                            @if ($task->room_id)
                            <a data-bs-toggle="tooltip" data-bs-placement="top"
                                href="{{ route('projets',['client_id'=>$task->room->stage->building->projet->client->id]) }}" title="Client">{{
                                $task->room->stage->building->projet->client->name }}</a> /
                            <a data-bs-toggle="tooltip" data-bs-placement="top"
                                href="{{ route('projet',['projet_id'=>$task->room->stage->building->projet->id]) }}" title="Projet">{{
                                $task->room->stage->building->projet->name }}</a> /
                            <a data-bs-toggle="tooltip" data-bs-placement="top"
                                href="{{ route('building', ['building_id'=>$task->room->stage->building->id]) }}" title="Batiment">{{
                                $task->room->stage->building->name }}</a> /
                            <a data-bs-toggle="tooltip" data-bs-placement="top"
                                href="{{ route('stage', ['stage_id'=>$task->room->stage->id]) }}" title="Niveau">{{ $task->room->stage->name
                                }}</a> /
                            <a data-bs-toggle="tooltip" data-bs-placement="top" href="{{ route('room', ['room_id'=>$task->room->id]) }}"
                                title="Local">{{ $task->room->name }}/</a>
                            @endif
                        </div>
                    @endisset
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                {{ $actions ?? '' }}
            </div>
            <div class="modal-body">

                {{ $slot }}

            </div>
            @isset ($method)
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary" wire:click="{{ $method }}">{{ $submit ?? 'Valider'
                    }}</button>
            </div>
            @endisset
        </div>
    </div>
</div>
