<div>
    <button class="btn btn-primary" wire:click="$dispatch('open-addProvider')">
        <i class="ti ti-plus"></i> Fournisseur
    </button>

    @component('components.modal', ["id"=>'addProvider', 'title'=>'Ajouter un fournisseur'])
        <form class="row" wire:submit="store">

            @include('_form.provider_form')

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-addProvider', event => { $('#addProvider').modal('show'); }) </script>
        <script> window.addEventListener('close-addProvider', event => { $('#addProvider').modal('hide'); }) </script>
    @endcomponent
</div>
