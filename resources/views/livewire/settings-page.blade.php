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
                            <a href="#" wire:click="$set('tab', 2)" class="list-group-item list-group-item-action @if($tab==2)active @endif">Utilisateurs</a>
                            <a href="#" wire:click="$set('tab', 3)" class="list-group-item list-group-item-action @if($tab==3)active @endif">Status et priorités</a>
                            <a href="#" wire:click="$set('tab', 4)" class="list-group-item list-group-item-action @if($tab==4)active @endif">Permissions et Roles</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-9 d-flex flex-column">
                    @if ($tab == 0)
                        @livewire('settings.user-account', ['user' => $user], key($user->id))
                    @elseif($tab == 1)
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h2>Notifications</h2>
                                <button class="btn btn-icon" wire:click='$refresh'><i class="ti ti-reload"></i> </button>
                            </div>
                        </div>
                    @elseif($tab == 2)
                        @livewire('settings.userslist')
                    @elseif($tab == 3)
                        @livewire('settings.task-status-list')
                    @elseif($tab == 4)
                        @livewire('settings.permissions')
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

