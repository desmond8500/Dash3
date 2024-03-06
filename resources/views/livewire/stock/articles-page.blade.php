<div>
    @component('components.layouts.page-header', ['title'=> 'Articles', 'breadcrumbs'=> $breadcrumbs])
        <div class="btn-list">
            @livewire('form.article-add')
            @livewire('form.provider-add')
            @livewire('form.brand-add')
        </div>
    @endcomponent

    <div class="row g-2">
        <div class="col-md-2">
            <div>
                <div class="input-group">
                    <input type="text" class="form-control" wire:model.live="search" placeholder="Rechercher" wire:click="articleSearch">
                    {{-- <input type="text" class="form-control" wire:model.defer="search" placeholder="Rechercher" wire:keydown.enter='getArticles'> --}}
                    {{-- <button class="btn btn-primary btn-icon" wire:click="getArticles">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path stroke="none" d="M0 0h24v24H0z" fill="none"></path> <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path> <path d="M21 21l-6 -6"></path> </svg>
                    </button> --}}
                    @if ($search)
                        <button class="btn btn-secondary btn-icon" wire:click="resetSearch">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path stroke="none" d="M0 0h24v24H0z" fill="none"></path> <path d="M18 6l-12 12"></path> <path d="M6 6l12 12"></path> </svg>
                        </button>
                    @endif
                </div>

            </div>

        </div>
        <div class="col-md-10">
            <div class="row row-deck g-2">
                @foreach ($articles as $article)
                    <div class="col-md-4">
                        @include('_card.articleCard')
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
