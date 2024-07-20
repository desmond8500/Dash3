<div class="page-wrapper">
    @component('components.layouts.page-header', ['title'=> 'Paramètres'])

    @endcomponent

    <div class="page-body">
        <div class="card">
            <div class="row g-0">
                <div class="col-12 col-md-3 border-end">
                    <div class="card-body">
                        <h4 class="subheader">Paramètres utilisateur</h4>
                        <div class="list-group list-group-transparent">
                            <a href="#" wire:click="$set('tab', 0)" class="list-group-item list-group-item-action d-flex align-items-center @if($tab==0)active @endif">Mon Compte</a>
                            <a href="#" wire:click="$set('tab', 1)" class="list-group-item list-group-item-action d-flex align-items-center @if($tab==1)active @endif">My Notifications</a>
                        </div>
                        <h4 class="subheader mt-4">Paramètres Système</h4>
                        <div class="list-group list-group-transparent">
                            <a href="#" wire:click="$set('tab', 2)" class="list-group-item list-group-item-action">Utilisateurs</a>
                            <a href="#" wire:click="$set('tab', 3)" class="list-group-item list-group-item-action">Taches</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-9 d-flex flex-column">
                    @if ($tab == 0)
                        @livewire('settings.user-account', ['user' => $user], key($user->id))
                    @elseif($tab == 1)
                        <div class="card-body">
                            Notifications
                        </div>
                    @elseif($tab == 2)
                        <div class="card-body">
                            @foreach ($users as $user)
                                <div class="card p-2">
                                    <div class="row">
                                        <div class="col-auto">
                                            <img src="" alt="A" class="avatar avatar-md">
                                        </div>
                                        <div class="col">
                                            <div class="fw-bold">{{ $user->firstname }} {{ $user->lastname }}</div>
                                            <div class="">{{ $user->email }} </div>
                                            <div class="text-muted">Description</div>
                                        </div>
                                        <div class="col-auto">
                                          <button class="btn btn-outline-primary btn-icon" >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path stroke="none" d="M0 0h24v24H0z" fill="none"></path> <path d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4"></path> <path d="M13.5 6.5l4 4"></path> </svg>
                                          </button>
                                      </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @elseif($tab == 3)
                        <div class="card-body">
                            <div class="row row-deck">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="card-title">Status</div>
                                            <div class="card-actions">
                                                <div class="badge bg-primary">{{ $taskStatuses->count() }}</div>
                                                <button class="btn btn-action" wire:click="status_add">
                                                    <i class="ti ti-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            @foreach ($taskStatuses as $taskStatus)
                                                <div class="card p-2 my-1">
                                                    <div class="row">
                                                        <div class="col">{{ $taskStatus->name }}</div>
                                                        <div class="col-auto">
                                                            <div class="badge bg-{{ $taskStatus->color }}"> {{ $taskStatus->level }} </div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <button class="btn btn-sm" wire:click="status_edit('{{ $taskStatus->id }}')"> <i class="ti ti-edit"></i> </button>
                                                        </div>
                                                    </div>

                                                    {{-- <div class="d-flex justify-content-between">
                                                        <div>{{ $taskStatus->name }}</div>
                                                        <button class="btn btn-action"> <i class="ti ti-edit"></i> </button>
                                                        <button class="btn btn-action"> <i class="ti ti-edit"></i> </button>
                                                        <div class="badge bg-{{ $taskStatus->color }}" wire:click="status_edit('{{ $taskStatus->id }}')">{{ $taskStatus->level }}</div>
                                                    </div> --}}
                                                </div>
                                            @endforeach
                                        </div>
                                        {{-- <div class="card-footer">

                                        </div> --}}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="card-title">Priorite</div>
                                            <div class="card-actions">
                                                <div class="badge badge-primary">{{ $taskPriorities->count() }}</div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            @foreach ($taskPriorities as $taskPriority)
                                                <div class="card p-2 my-1">
                                                    <div class="d-flex justify-content-between">
                                                        <div>{{ $taskPriority->name }}</div>
                                                        <div class="badge ">{{ $taskPriority->level }}</div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        {{-- <div class="card-footer">

                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>


    @component('components.modal', ["id"=>'addStatus', 'title' => 'Ajouter un statut'])
        <form class="row" wire:submit="status_store">
            @include('_form.task_status_form')
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-addStatus', event => { $('#addStatus').modal('show'); }) </script>
        <script> window.addEventListener('close-addStatus', event => { $('#addStatus').modal('hide'); }) </script>
    @endcomponent

    @component('components.modal', ["id"=>'editStatus', 'title' => 'Editer un statut'])
        <form class="row" wire:submit="status_update">
            @include('_form.task_status_form')
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" wire:click='status_delete'> <i class="ti ti-trash"></i> </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-editStatus', event => { $('#editStatus').modal('show'); }) </script>
        <script> window.addEventListener('close-editStatus', event => { $('#editStatus').modal('hide'); }) </script>
    @endcomponent
</div>

