<div>
    @component('components.layouts.page-header', ['title'=> 'Clients', 'breadcrumbs' => $breadcrumbs])
        <div class="d-flex">
            <input type="text" class="form-control" wire:model.live="search" placeholder="Rechercher un client">

            <button type="button" class="btn btn-primary mx-1" wire:click="add()" data-bs-toggle="tooltip" title="Ajouter un client">
                <i class="ti ti-plus me-2"></i> Client
            </button>
            <button type="button" class="btn btn-primary btn-icon mx-1" wire:click='download_xls' data-bs-toggle="tooltip" title="Exporter en au format Excel">
                <i class="ti ti-file-spreadsheet "></i>
            </button>
            @env('local')
                <button class="btn btn-icon" wire:click='$refresh' data-bs-toggle="tooltip" title="Actualiser"><i class="ti ti-reload"></i> </button>
            @endenv
        </div>
    @endcomponent

    <div class="row row-deck g-2">

        @forelse ($clients as $client)
            <div class="col-md-4" wire:key="client-{{ $client->id }}">
                @include('_card.client_card')
            </div>
        @empty

        <div class="empty">
            <div class="empty-icon">
                <i class="ti ti-mood-empty"></i>
            </div>
            <p class="empty-title">Pas de client trouvé</p>
            <p class="empty-subtitle text-secondary">
                Ajoutez de nouveaux clients ou changez de critères de recherche.
            </p>
            <div class="empty-action">
                <button class="btn btn-primary" wire:click='clientSearch()'>
                    <i class="ti ti-mood-empty"></i>
                    Rechercher de nouveau
                </button>
            </div>
        </div>

        @endforelse

        <div>
            {{ $clients->links() }}
        </div>
    </div>

    @component('components.modal', ["id"=>'addClient', 'title'=>'Ajouter un client', 'method'=>'store'])
        <form class="row" wire:submit="store">
            @include('_form.client_form')
        </form>

        <script> window.addEventListener('open-addClient', event => { $('#addClient').modal('show'); }) </script>
        <script> window.addEventListener('close-addClient', event => { $('#addClient').modal('hide'); }) </script>
    @endcomponent
    @component('components.modal', ["id"=>'editClient', 'title'=>'Modifier un client', 'method'=>'update'])
        <form class="row" wire:submit="update">
            @include('_form.client_form')
        </form>
        <script> window.addEventListener('open-editClient', event => { $('#editClient').modal('show'); }) </script>
        <script> window.addEventListener('close-editClient', event => { $('#editClient').modal('hide'); }) </script>
    @endcomponent

</div>
