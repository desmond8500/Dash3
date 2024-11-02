<div>
    <button class='btn btn-primary' wire:click="dispatch('open-addTransaction')" data-bs-toggle="tooltip" title="Ajouter une transaction">
        <i class='ti ti-plus'></i> Transaction
    </button>

    @component('components.modal', ["id"=>'addTransaction', 'title' => 'Ajouter une transaction'])
        <form class="row" wire:submit="store">
            @include('_form.transaction_form')
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-addTransaction', event => { $('#addTransaction').modal('show'); }) </script>
        <script> window.addEventListener('close-addTransaction', event => { $('#addTransaction').modal('hide'); }) </script>
    @endcomponent
</div>
