<div>
    @component('components.layouts.page-header', ['title'=> 'Marque', 'breadcrumbs'=>$breadcrumbs])

    @endcomponent

    <div class="row g-2">
        <div class="col-md-4">
            <div class="card mb-2">
                <div class="card-header">
                    <div class="card-title">{{ $brand->name }}</div>
                    <div class="card-actions">
                        <button class="btn btn-primary btn-icon" wire:click="edit_brand('{{ $brand->id }}')">
                            <i class="ti ti-edit"></i>
                        </button>
                    </div>
                </div>
                @if ($brand->description)
                    <div class="card-body">
                        <div class="">{!! $brand->description !!}</div>
                    </div>
                @endif
            </div>
            @if ($links->count())
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Liens</div>
                        <div class="card-actions">
                            <button class="btn btn-primary" wire:click="$dispatch('open-addBrandLink')">
                                <i class="ti ti-plus"></i> Lien
                            </button>
                        </div>
                    </div>
                    <div class="p-2">
                        @foreach ($links as $link)
                            <div class="d-flex justify-content-between align-items-center border m-1 p-1 rounded">
                                <div>{{ $link->name }}</div>
                                <div>
                                    <a href="{{ $link->link }}" target="_blank" class="btn btn-icon btn-primary">
                                        <i class="ti ti-eye"></i>
                                    </a>
                                    <button wire:click="link_delete('{{ $link->id }}')" class="btn btn-icon btn-danger">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-12 mb-2">
                    <input type="text" class="form-control" wire:model.live="search" placeholder="Chercher">
                </div>
                @foreach ($articles as $article)
                    <div class="col-md-6">
                        @include('_card.articleCard')
                    </div>
                @endforeach
            </div>
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

    @component('components.modal', ["id"=>'addBrandLink', 'title' => 'Ajouter un lien ou un document'])
        <form class="row" wire:submit="link_store">
            @include('_form.brand_link')
        </form>
        <script> window.addEventListener('open-addBrandLink', event => { $('#addBrandLink').modal('show'); }) </script>
        <script> window.addEventListener('close-addBrandLink', event => { $('#addBrandLink').modal('hide'); }) </script>
    @endcomponent
</div>
