<div>
    @component('components.layouts.page-header', ['title'=> 'Fournisseurs', 'breadcrumbs'=> $breadcrumbs])
        @livewire('form.provider-add')
    @endcomponent

    <div class="row g-2">
        <div class="col-md-12">
            <div class="input-icon">
                <input type="text" class="form-control form-control-rounded" wire:model.live="search" placeholder="Chercher un fournisseur">
                <span class="input-icon-addon ">
                    <i class="ti ti-search"></i>
                </span>
            </div>
        </div>
        @foreach ($providers as $provider)
            <div class="col-md-4">
                <div class="card p-2">
                    <div class="row">
                        <a class="col-auto" href="{{ route('provider',['provider_id'=>$provider->id]) }}">
                            <img src="{{ asset($provider->logo) }}" alt="A" class="avatar avatar-md">
                        </a>
                        <a class="col" href="{{ route('provider',['provider_id'=>$provider->id]) }}">
                            <div class="card-title">{{ $provider->name }}</div>
                            <div class="text-muted">{{ nl2br($provider->description) }}</div>
                        </a>
                        <div class="col-auto">
                            <div class="dropdown open">
                                <button class="btn btn-action" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                                    <i class="ti ti-chevron-down"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="triggerId">
                                    <a class="dropdown-item" wire:click="edit('{{ $provider->id }}')"> <i class="ti ti-edit"></i> Editer</a>
                                    <a class="dropdown-item" wire:click="edit_logo('{{ $provider->id }}')"> <i class="ti ti-edit"></i> Editer Logo</a>
                                    <a class="dropdown-item text-danger" wire:click="delete('{{ $provider->id }}')"> <i class="ti ti-trash"></i> Supprimer</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="col-md-12">
            {{ $providers->links() }}
        </div>
    </div>

    @component('components.modal', ["id"=>'editProvider', 'title' => 'Editer un fournisseur'])
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
        <script> window.addEventListener('open-editProvider', event => { window.$('#editProvider').modal('show'); }) </script>
        <script> window.addEventListener('close-editProvider', event => { window.$('#editProvider').modal('hide'); }) </script>
    @endcomponent

    @component('components.modal', ["id"=>'editLogo', 'title' => 'Editer un logo'])
    <form class="" wire:submit="update_logo">
        <div class="text-center mb-3">
            <div wire:loading>
                Chargement <div class="spinner-border" role="status"></div>
            </div>
            <div class="my-2">
                @if ($logo)
                    @if (is_string($logo))
                        <img src="{{ asset($logo) }}" class="avatar avatar-xl">
                    @else
                        <img src="{{ $logo->temporaryUrl() }}" class="avatar avatar-xl">
                    @endif
                    @else
                    <input type="file" class="form-control" wire:model='logo'>
                @endif
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            <button type="submit" class="btn btn-primary">Valider</button>
        </div>
    </form>
    <script> window.addEventListener('open-editLogo', event => { window.$('#editLogo').modal('show'); }) </script>
    <script> window.addEventListener('close-editLogo', event => { window.$('#editLogo').modal('hide'); }) </script>
    @endcomponent

</div>
