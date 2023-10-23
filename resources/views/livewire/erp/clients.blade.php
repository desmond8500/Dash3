<div>
    @component('components.layout.page-header', ['title'=> 'Clients', 'breadcrumbs' => $breadcrumbs])
    <div class="d-flex">

        <div class="input-group">
            <input type="text" class="form-control" placeholder="Rechercher">
            <button class="btn btn-primary" wire:click='clientSearch'> <i class="ti ti-search"></i> </button>
        </div>

        <button type="button" class="btn btn-primary mx-1" data-bs-toggle="modal" data-bs-target="#addSection">
            <i class="ti ti-plus me-2"></i> Button
        </button>

    </div>
    @endcomponent

    <div class="row row-deck">
        @forelse ($clients as $client)
            {{ $client->name }}
        @empty

        <div class="empty">
            <div class="empty-icon">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path stroke="none" d="M0 0h24v24H0z" fill="none" /> <circle cx="12" cy="12" r="9" /> <line x1="9" y1="10" x2="9.01" y2="10" /> <line x1="15" y1="10" x2="15.01" y2="10" /> <path d="M9.5 15.25a3.5 3.5 0 0 1 5 0" /> </svg>
            </div>
            <p class="empty-title">Pas de client trouvé</p>
            <p class="empty-subtitle text-secondary">
                Ajoutez de nouveaux clients ou changez de critères de recherche.
            </p>
            <div class="empty-action">
                <button class="btn btn-primary" wire:click='clientSearch'>
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path stroke="none" d="M0 0h24v24H0z" fill="none" /> <circle cx="10" cy="10" r="7" /> <line x1="21" y1="21" x2="15" y2="15" /> </svg>
                    Rechercher de nouveau
                </button>
            </div>
        </div>

        @endforelse
    </div>

    @component('components.modal.modal_add',[
        'id' => "addSection",
        'title' => "Ajouter une section",
        'method' => "store"
        ])
        @include('_form.client_form')

       <script> window.addEventListener('close-modal', event => { $("#addSection").modal('hide'); }) </script>
    @endcomponent

</div>
