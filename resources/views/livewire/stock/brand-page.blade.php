<div>
    @component('components.layouts.page-header', ['title'=> 'Marque', 'breadcrumbs'=>$breadcrumbs])
        livewire
    @endcomponent

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{ $brand->name }}</div>
                    <div class="card-actions">
                        <button class="btn btn-primary btn-icon" wire:click="edit_brand('{{ $brand->id }}')">
                            <i class="ti ti-edit"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="">{!! $brand->description !!}</div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-12 mb-3">
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
</div>
