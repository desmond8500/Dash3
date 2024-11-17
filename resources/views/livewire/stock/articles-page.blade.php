<div>
    @component('components.layouts.page-header', ['title'=> "Articles", 'breadcrumbs'=> $breadcrumbs])
        <div class="btn-list">
            @livewire('form.article-add')
            @livewire('form.provider-add')
            @livewire('form.brand-add')
            <button class="btn btn-icon" wire:click='$refresh'><i class="ti ti-reload"></i> </button>
        </div>
    @endcomponent

    <div class="row g-2">
        <div class="col-md-3">
            <div class="mb-1">
                <div class="input-group">
                    <input type="text" class="form-control" wire:model.live="search" placeholder="Trouver un article">

                    <button class="btn btn-icon" wire:click='reset_filter()'><i class="ti ti-reload"></i> </button>
                </div>
            </div>

            <div class="card">

                <div class="accordion accordion-flush" id="accordionFlushExample">
                    @component('components.accordion-item',['id'=> 'brand', 'title'=>"Marques"])
                        @foreach ($brands->sortby('name') as $brand)
                            <button class="btn btn-primary btn-sm rounded mb-1" wire:click="$set('brand_id','{{ $brand->id }}')">{{ $brand->name }}</button>
                        @endforeach
                    @endcomponent
                    @component('components.accordion-item',['id'=> 'provider', 'title'=>"Fournisseurs"])
                        @foreach ($providers->sortby('name') as $provider)
                        <button class="btn btn-primary btn-sm rounded mb-1" wire:click="$set('provider_id','{{ $provider->id }}')">{{ $provider->name }}</button>
                        @endforeach
                    @endcomponent
                    @component('components.accordion-item',['id'=> 'priorite', 'title'=>"Priorités"])
                        @foreach ($priorites as $priorite)
                        <button class="btn btn-primary btn-sm rounded mb-1" wire:click="$set('priorite_id','{{ $priorite->id }}')">{{ $priorite->name }}</button>
                        @endforeach
                    @endcomponent
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="row row-deck g-2">
                @foreach ($articles as $article)
                    <div class="col-md-6">
                        @include('_card.articleCard',[
                            'edit' => true
                        ])
                    </div>
                @endforeach
                <div class="col-md-12">
                    {{ $articles->links() }}
                </div>
            </div>
        </div>
    </div>

    @component('components.modal', ["id"=>'editArticle', 'title'=>'Editer un article'])
        <form class="row" wire:submit="update">
            @include('_form.article_form')
            <div class="modal-footer">
                <button type="button" class="btn btn-danger me-auto" wire:click='delete'>
                    <i class="ti ti-trash"></i>
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-editArticle', event => { $('#editArticle').modal('show'); }) </script>
        <script> window.addEventListener('close-editArticle', event => { $('#editArticle').modal('hide'); }) </script>
    @endcomponent
</div>
