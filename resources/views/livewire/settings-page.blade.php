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
                            Utilisateurs
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
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            @foreach ($taskStatuses as $taskStatus)
                                                <div class="card p-2 my-1">
                                                    <div class="d-flex justify-content-between">
                                                        <div>{{ $taskStatus->name }}</div>
                                                        <div class="badge ">{{ $taskStatus->level }}</div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="card-footer">

                                        </div>
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
                                        <div class="card-footer">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>

