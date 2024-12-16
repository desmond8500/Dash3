<div>
    @component('components.layouts.page-header', ['title'=> 'Fournisseur', 'breadcrumbs'=>$breadcrumbs])
        <button class="btn btn-primary" wire:click="edit()">Editer</button>
        <button class="btn btn-primary" wire:click="$dispatch('open-editLogo')">Editer Logo</button>

    @endcomponent



    <div class="row">
        <div class="col-md-4">
            <div class="card card-body mb-2">
                <img src="{{ asset($provider->logo) }}" alt="L" class="img-fluid">
            </div>

            <div class="card card-body mb-2">
                {{ $provider->name }}
            </div>
        </div>

        <div class="col-md-8">
            <div class="row">
                <div class="col-md-12">
                    <div class="input-icon mb-2">
                        <input type="text" class="form-control form-control-rounded" wire:model.live="search" placeholder="Chercher article">
                        <span class="input-icon-addon">
                            <i class="ti ti-search"></i>
                        </span>
                    </div>
                </div>

                @foreach ($articles as $article)
                    <div class="col-md-6">
                        @include('_card.articleCard')
                    </div>
                @endforeach
            </div>
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
