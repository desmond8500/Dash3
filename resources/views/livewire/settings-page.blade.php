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
                            <a href="#" class="list-group-item list-group-item-action">Utilisateurs</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-9 d-flex flex-column">
                    @if ($tab == 0)
                        @livewire('settings.user-account', ['user' => $user], key($user->id))
                    @elseif($tab == 1)
                        Notifications
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>

