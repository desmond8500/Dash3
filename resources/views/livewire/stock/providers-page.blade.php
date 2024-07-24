<div>
    @component('components.layouts.page-header', ['title'=> 'Fournisseurs', 'breadcrumbs'=> $breadcrumbs])
        @livewire('form.provider-add')
    @endcomponent

    <div class="row g-2">
        <div class="col-md-12">
            <div class="input-group">
                <input type="text" class="form-control" wire:model.live="search" placeholder="Rechercher">
            </div>
        </div>
        @foreach ($providers as $provider)
            <div class="col-md-3">
                <div class="card p-2">
                    <div class="row">
                        <div class="col-auto">
                            <img src="" alt="A" class="avatar avatar-md">
                        </div>
                        <div class="col">
                            <div class="card-title">{{ $provider->name }}</div>
                            <div class="text-muted">{{ nl2br($provider->description) }}</div>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-outline-primary btn-icon" wire:click="edit('{{ $provider->id }}')">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path stroke="none" d="M0 0h24v24H0z" fill="none"></path> <path d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4"></path> <path d="M13.5 6.5l4 4"></path> </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @component('components.modal', ["id"=>'editProvider'])
        <form class="row" wire:submit="update">
            @include('_form.provider_form')
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-danger btn-icon" wire:click="delete()">
                    <i class="ti ti-trash"></i>
                </button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-editProvider', event => { $('#editProvider').modal('show'); }) </script>
        <script> window.addEventListener('close-editProvider', event => { $('#editProvider').modal('hide'); }) </script>
    @endcomponent

</div>
