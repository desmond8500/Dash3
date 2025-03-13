<div>
    @component('components.layouts.page-header', ['title'=> 'Connexion'])

    @endcomponent

    <div>
        Veuillez vous connecter
    </div>

</div>


<button class='btn btn-primary' wire:click="$dispatch('open-addModal')" ><i class='ti ti-plus'></i> Bouton</button>

@component('components.modal', ["id"=>'addModal', 'title' => 'Titre'])
    <form class="row" wire:submit="store">
        @include('_form.document_form')
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            <button type="submit" class="btn btn-primary">Valider</button>
        </div>
    </form>
    <script> window.addEventListener('open-addModal', event => { window.$('#addModal').modal('show'); }) </script>
    <script> window.addEventListener('close-addModal', event => { window.$('#addModal').modal('hide'); }) </script>
@endcomponent
