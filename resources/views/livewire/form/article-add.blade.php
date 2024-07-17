<div>
    <a class="btn btn-primary" wire:click="add"><i class="ti ti-plus"></i> Article </a>

    @component('components.modal', ["id"=>'addArticle', 'title'=>'Ajouter un article'])
        <form class="row" wire:submit="store">
            {{-- @include('_form.article_form',['providers' => $providers, 'brands'=> $brands]) --}}
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-addArticle', event => { $('#addArticle').modal('show'); }) </script>
        <script> window.addEventListener('close-addArticle', event => { $('#addArticle').modal('hide'); }) </script>
    @endcomponent

</div>
