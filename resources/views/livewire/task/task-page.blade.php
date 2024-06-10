<div>
    @component('components.layouts.page-header', ['title'=> 'Tache'])

    @endcomponent

    <div class="row">
        <div class="col-md-4">

            <div class="card">
                <div class="card-header">
                    <div class="card-title">Tache secondaire</div>
                    <div class="card-actions">
                        <button class="btn btn-primary" disabled wire:click="dispatch('open-editTaskModal')">
                            <i class="ti ti-plus" ></i> Tache
                        </button>
                    </div>
                </div>
                <ul class="list-group list-group-numbered">
                    <li class="list-group-item ">Active item</li>
                    <li class="list-group-item ">Item</li>
                    <li class="list-group-item ">Disabled item</li>
                </ul>
            </div>

        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div>
                        <h2 class=""> {{ $task->name }} </h2>
                        <div class="">
                            @if ($task->client_id)
                            <a data-bs-toggle="tooltip" data-bs-placement="top" href="{{ route('projets',['client_id'=>$task->client->id]) }}"
                                title="Client">{{ $task->client->name }}</a>
                            @endif

                            @if ($task->projet_id)
                            <a data-bs-toggle="tooltip" data-bs-placement="top"
                                href="{{ route('projets',['client_id'=>$task->projet->client->id]) }}" title="Client">{{
                                $task->projet->client->name
                                }}</a>
                            <a data-bs-toggle="tooltip" data-bs-placement="top" href="{{ route('projet',['projet_id'=>$task->projet->id]) }}"
                                title="Projet">{{ $task->projet->name }}</a>
                            @endif

                            @if ($task->building_id)
                            <a data-bs-toggle="tooltip" data-bs-placement="top"
                                href="{{ route('projets',['client_id'=>$task->building->projet->client->id]) }}" title="Client">{{
                                $task->building->projet->client->name }}</a>
                            <a data-bs-toggle="tooltip" data-bs-placement="top"
                                href="{{ route('projet',['projet_id'=>$task->building->projet->id]) }}" title="Projet">{{
                                $task->building->projet->name }}</a>
                            <a data-bs-toggle="tooltip" data-bs-placement="top"
                                href="{{ route('building', ['building_id'=>$task->building->id]) }}" title="Batiment">{{ $task->building->name
                                }}</a>
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
                                }}</a>
                            <a data-bs-toggle="tooltip" data-bs-placement="top" href="{{ route('room', ['room_id'=>$task->room->id]) }}"
                                title="Local">{{ $task->room->name }}/</a>
                            @endif
                        </div>
                    </div>
                    <div class="card-actions">
                        <button class="btn btn-primary btn-icon" wire:click="dispatch('open-editTaskModal')">
                            <i class="ti ti-edit"></i>
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <b>Priorité:</b>
                            <span class="badge badge-pill mb-1
                                    @if($task->priority_id ==1) bg-primary  @endif
                                    @if($task->priority_id ==2) bg-warning  @endif
                                    @if($task->priority_id ==3) bg-danger  @endif
                                "> {{ $task->priority->name }}
                            </span>
                        </div>
                        <div class="col-md-4">
                            <b>Statut:</b>
                            <span class="badge badge-pill mb-1
                                @if($task->statut_id ==1) bg-primary  @endif
                                @if($task->statut_id ==2) bg-warning  @endif
                                @if($task->statut_id ==3) bg-secondary @endif
                                @if($task->statut_id ==4) bg-success  @endif
                            ">{{ $task->statut->name }}</span>
                        </div>
                        <div class="col-md-4">
                            @if ($task->expiration_date)
                                <b>Expiration:</b> {{ $task->expiration_date }}
                            @endif
                        </div>
                    </div>

                </div>

                <div class="card-body">
                    <h3>Description</h3>
                    <div>{{ nl2br($task->description) }}</div>
                </div>

                @env('local')
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h3>Fichiers joints</h3>
                            <button class="btn btn-primary" disabled>
                                <i class="ti ti-plus"></i> Fichier
                            </button>
                        </div>
                        <div class="row">
                            <div class="col-md-3 border rounded p-1">
                                <div class="row">
                                    <div class="col-auto">
                                        <img src="" class="avatar " alt="PDF">
                                    </div>
                                    <div class="col">
                                        <div>Fichier.pdf</div>
                                        <div class="text-muted">
                                            Télécharger
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-lg btn-icon">
                                    <i class="ti ti-plus"></i>
                                </button>
                            </div>
                        </div>


                    </div>

                @endenv

                @env('local')
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h3>Sous Taches</h3>
                            <button class="btn btn-primary" disabled>
                                <i class="ti ti-plus"></i> Tache
                            </button>
                        </div>
                    </div>

                @endenv
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
