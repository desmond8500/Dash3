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
            <div class="input-group">
                <input type="text" class="form-control" wire:model.live="search" placeholder="Rechercher">
            </div>
        </div>
        <div class="col-md-10">
            <div class="row row-deck g-2">
                @foreach ($articles as $article)
                    <div class="col-md-6">
                        @include('_card.articleCard')
                    </div>
                @endforeach
                <div class="col-md-12">
                    {{ $articles->links() }}
                </div>

            </div>
        </div>
    </div>


    {{-- @component('components.modal', ["id"=>'editArticle', 'title'=>'Editer un article'])
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
    @endcomponent --}}
</div>
