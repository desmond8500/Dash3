<div>
    <button class="btn btn-primary" wire:click="$dispatch('open-addJournal')">
        <i class="ti ti-plus"></i> Journal
    </button>

    @component('components.modal', ["id"=>'addJournal', 'title'=> 'Ajouter une entrée au journal'])
        <form class="row" wire:submit="store">
            @include('_form.journal_form')

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-addJournal', event => { window.$('#addJournal').modal('show'); }) </script>
        <script> window.addEventListener('close-addJournal', event => { window.$('#addJournal').modal('hide'); }) </script>
    @endcomponent
</div>
