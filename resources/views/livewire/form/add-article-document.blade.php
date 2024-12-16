<div>
    <button class='btn btn-primary' wire:click="$dispatch('open-addArticleDocument')" ><i class='ti ti-plus'></i> Document</button>

    @component('components.modal', ["id"=>'addArticleDocument', 'title' => 'Ajouter un document'])
        <form class="row" wire:submit="store">
            @include('_form.article_document_form')
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-addArticleDocument', event => { window.$('#addArticleDocument').modal('show'); }) </script>
        <script> window.addEventListener('close-addArticleDocument', event => { window.$('#addArticleDocument').modal('hide'); }) </script>
    @endcomponent

</div>
