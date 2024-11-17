<div>
    @component('components.layouts.page-header', ['title'=>'Marques', 'breadcrumbs'=>$breadcrumbs])
        <div class="btn-list">
            @livewire('form.brand-add')
            <button class="btn btn-icon" wire:click='$refresh'><i class="ti ti-reload"></i> </button>
        </div>
    @endcomponent

    <div class="row row-deck g-2">
        <div class="col-md-12">
            <div class="input-icon">
                <input type="text" class="form-control form-control-rounded" wire:model.live="search" placeholder="Chercher une marque">
                <span class="input-icon-addon">
                    <i class="ti ti-search"></i>
                </span>
            </div>
        </div>
        @foreach ($brands as $brand)
            <div class="col-md-4">
                <div class="card p-2">
                    <div class="row">
                        <div class="col-auto">
                            <img src="{{ asset($brand->logo) ?? 'https://avatar.iran.liara.run/public' }}" alt="M" class="avatar avatar-md">
                        </div>
                        <div class="col">
                            <a class="card-title" href="{{ route('brand',['brand_id'=>$brand->id]) }}">{{ $brand->name }}</a>
                            <div class="text-muted">{!! nl2br($brand->description) !!}</div>
                        </div>
                        <div class="col-auto">
                            <div class="dropdown open">
                                <button class="btn btn-action" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                                    <i class="ti ti-chevron-down"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="triggerId">
                                    <a class="dropdown-item" wire:click="edit_brand('{{ $brand->id }}')"> <i class="ti ti-edit"></i> Editer</a>
                                    <a class="dropdown-item" wire:click="edit_logo('{{ $brand->id }}')"> <i class="ti ti-edit"></i> Editer image</a>
                                    <a class="dropdown-item text-danger" wire:click="delete_brand('{{ $brand->id }}')"> <i class="ti ti-trash"></i> Supprimer</a>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-12">
                            {{-- @dump($brand->article()->count()) --}}
                            {{-- <div class="text-muted">{{ $brand->article}}</div> --}}
                        </div>
                    </div>
                </div>
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
        <script> window.addEventListener('open-editBrand', event => { $('#editBrand').modal('show'); }) </script>
        <script> window.addEventListener('close-editBrand', event => { $('#editBrand').modal('hide'); }) </script>
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
        <script> window.addEventListener('open-editBrandLogo', event => { $('#editBrandLogo').modal('show'); }) </script>
        <script> window.addEventListener('close-editBrandLogo', event => { $('#editBrandLogo').modal('hide'); }) </script>
    @endcomponent
</div>
