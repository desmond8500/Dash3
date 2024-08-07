<div>
    <div class="row">
        <div class="col">

        </div>
        <div class="col-auto">
            <button class="btn btn-primary" ><i class="ti ti-plus"></i> Ajouter un quantitatif</button>
        </div>
    </div>

    @component('components.modal', ["id"=>'addQuantitatif', 'title'=>'Ajouter un quantitatif'])
    <form class="row" wire:submit="quantitatif_store">

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            <button type="submit" class="btn btn-primary">Valider</button>
        </div>
    </form>
    <script> window.addEventListener('open-addQuantitatif', event => { $('#addQuantitatif').modal('show'); }) </script>
    <script> window.addEventListener('close-addQuantitati', event => { $('#addQuantitati').modal('hide'); }) </script>
    @endcomponent
</div>
