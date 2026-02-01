<div>
    @component('components.layouts.page-header', ['title' => 'Projets', 'breadcrumbs' => $breadcrumbs])
        <div class="d-flex" style="gap:5px">
            <input type="text" class="form-control mr-1" wire:model.live="search" placeholder="Rechercher"
                wire:keydown.enter='ProjetSearch'>

            <button class="btn btn-primary ms-1" wire:click="$dispatch('open-addProjet')">
                <i class="ti ti-plus"></i> Projet
            </button>
            @livewire('form.task-add', ['client_id' => $client_id])
            <button class="btn btn-primary btn-icon" wire:click="edit_client({{ $client_id }})">
                <i class="ti ti-edit"></i>
            </button>
            @env('local')
            <button class="btn btn-icon" wire:click='$refresh'><i class="ti ti-reload"></i> </button>
            @endenv
        </div>
    @endcomponent

    <div class="row">
        <div class="col-md-3">
            @livewire('cards/client_card_extended', ['client_id' => $client_id])
        </div>

        <div class="col-md-9">
            <div class="row row-deck g-2">
                <div class="col-md-12 bg-white mb-3 p-1 rounded">
                    <nav class="nav nav-segmented" role="tablist" wire:ignore>
                        <button class="nav-link active" role="tab" data-bs-toggle="tab" aria-selected="true" aria-current="page" wire:click="$set('tab', 'projets')">
                            Projets <span class="badge bg-blue text-blue-fg badge-pill">{{ $projets->count() }}</span>
                        </button>
                        <button class="nav-link" role="tab" data-bs-toggle="tab" aria-selected="false" tabindex="-1" wire:click="$set('tab', 'taches')">
                            Taches <span class="badge bg-blue text-blue-fg badge-pill">{{ $taches->count() }}</span>
                        </button>
                        <button class="nav-link" role="tab" data-bs-toggle="tab" aria-selected="false" tabindex="-1" wire:click="$set('tab', 'contacts')">
                            Contacts <span class="badge bg-blue text-blue-fg badge-pill">{{ $contacts->count() }}</span>
                        </button>
                        <button class="nav-link" disabled role="tab" data-bs-toggle="tab" aria-selected="false" tabindex="-1" wire:click="$set('tab', 'contacts')">
                            Timeline
                        </button>
                    </nav>
                </div>
                @switch($tab)
                    @case("projets")
                        @forelse ($projets as $projet)
                            <div class="col-md-4">
                                @include('_card.projet_card')
                            </div>
                        @empty
                            @component('components.no-result')
                            @endcomponent
                        @endforelse
                        <div class="mt-1">
                            {{ $projets->links() }}
                        </div>
                        @break
                    @case("taches")
                    @livewire('erp.tasks.tasklist1', ['client_id' => $client_id])

                        @break
                    @case("contacts")
                        <div class="border border-primary p-2 rounded mt-2">
                            @livewire('contact-list', ['client_id' => $client_id, 'card_class' => 'col-md-4'])
                        </div>
                        @break
                    @default

                @endswitch

            </div>
        </div>

    </div>

    @component('components.modal', ['id' => 'addProjet', 'title' => 'Ajouter un projet', 'method' => 'store'])
        <form class="row" wire:submit="store">
            @include('_form.projet_form')
        </form>
        <script>
            window.addEventListener('open-addProjet', event => {
                window.$('#addProjet').modal('show');
            })
        </script>
        <script>
            window.addEventListener('close-addProjet', event => {
                window.$('#addProjet').modal('hide');
            })
        </script>
    @endcomponent

    @component('components.modal', ['id' => 'editProjet', 'title' => 'Editer un projet', 'method' => 'update'])
        <form class="row" wire:submit="update">
            @include('_form.projet_form')
        </form>
        <script>
            window.addEventListener('open-editProjet', event => {
                window.$('#editProjet').modal('show');
            })
        </script>
        <script>
            window.addEventListener('close-editProjet', event => {
                window.$('#editProjet').modal('hide');
            })
        </script>
    @endcomponent

    @component('components.modal', ['id' => 'editClient', 'title' => 'Modifier un client', 'method' => 'update_client'])
        <form class="row" wire:submit="update_client">
            @include('_form.client_form')
        </form>
        <script>
            window.addEventListener('open-editClient', event => {
                $('#editClient').modal('show');
            })
        </script>
        <script>
            window.addEventListener('close-editClient', event => {
                $('#editClient').modal('hide');
            })
        </script>
    @endcomponent
</div>
