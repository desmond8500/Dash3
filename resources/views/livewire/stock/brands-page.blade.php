<div>
    @component('components.layouts.page-header', ['title'=>'Marques', 'breadcrumbs'=>$breadcrumbs])
        <div class="btn-list">
            @livewire('form.brand-add')

        </div>
    @endcomponent

    <div class="row row-deck g-2">
        <div class="col-md">
            <div class="input-icon">
                <input type="text" class="form-control form-control-rounded" wire:model.live="search" placeholder="Chercher une marque">
                <span class="input-icon-addon">
                    <i class="ti ti-search"></i>
                </span>
            </div>
        </div>
        <div class="col-auto">
            <div class="btn-list">
                <button class="btn btn-icon" wire:click="$set('card_type', 1)"><i class="ti ti-list-details"></i> </button>
                <button class="btn btn-icon" wire:click="$set('card_type', 2)"><i class="ti ti-list"></i> </button>
                <button class="btn btn-icon" wire:click="$set('card_type', 3)"><i class="ti ti-layout-grid"></i> </button>
            </div>
        </div>
        <div class="w-100"></div>
        @foreach ($brands as $brand)
            @if ($card_type == 3)
                <div class="col-md-2">
            @else
                <div class="col-md-4">
            @endif
                @include('_card.brand_card')
            </div>
        @endforeach
        <div class="col-md-12">
            {{ $brands->links() }}
        </div>
    </div>

    @component('components.modal', ["id"=>'editBrand', 'title' => 'Editer une marque'])
        <form class="row" wire:submit="update_brand">
            @include('_form.article_brand_form')
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-editBrand', event => { window.$('#editBrand').modal('show'); }) </script>
        <script> window.addEventListener('close-editBrand', event => { window.$('#editBrand').modal('hide'); }) </script>
    @endcomponent

    @component('components.modal', ["id"=>'editBrandLogo', 'title' => 'Editer une marque'])
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
                <button type="submit" class="btn btn-primary">Modifier</button>
            </div>
        </form>
        <script> window.addEventListener('open-editBrandLogo', event => { window.$('#editBrandLogo').modal('show'); }) </script>
        <script> window.addEventListener('close-editBrandLogo', event => { window.$('#editBrandLogo').modal('hide'); }) </script>
    @endcomponent
</div>
