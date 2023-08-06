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
        @foreach ($clients as $client)
            {{ $client->name }}
        @endforeach
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
