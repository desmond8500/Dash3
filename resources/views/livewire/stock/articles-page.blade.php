<div>
    @component('components.layouts.page-header', ['title'=> 'Articles', 'breadcrumbs'=> $breadcrumbs])
        <div class="btn-list">
            @livewire('form.article-add')
            @livewire('form.provider-add')
        </div>
        {{-- @livewire('form.article-add') --}}
    @endcomponent

    <div class="row row-deck g-2">
        @foreach ($articles as $article)
            <div class="col-md-4">
                @include('_card.articleCard')
            </div>
        @endforeach
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
