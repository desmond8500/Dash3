<div>
    <div class="d-flex justify-content-between">
        <h2>Notes</h2>
        <button class="btn btn-primary btn-pill" wire:click="$dispatch('open-addProjetNote')">
            <i class="ti ti-plus"></i> Note
        </button>
    </div>
    <div class="row">
        @foreach ($notes as $note)
            <div class="col-md-4">
                @include('_card.projet_note_card')
            </div>
        @endforeach
    </div>

    @component('components.modal', ["id"=>'addProjetNote', 'title' => 'Ajouter une note'])
        <form class="row" wire:submit="store">
            @include('_form.projet_note_form')
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-addProjetNote', event => { window.$('#addProjetNote').modal('show'); }) </script>
        <script> window.addEventListener('close-addProjetNote', event => { window.$('#addProjetNote').modal('hide'); }) </script>
    @endcomponent

    @component('components.modal', ["id"=>'editProjetNote', 'title' => 'Ajouter une note'])
        <form class="row" wire:submit="update">
            @include('_form.projet_note_form')
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-editProjetNote', event => { window.$('#editProjetNote').modal('show'); }) </script>
        <script> window.addEventListener('close-editProjetNote', event => { window.$('#editProjetNote').modal('hide'); }) </script>
    @endcomponent
</div>
