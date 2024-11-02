<div>
    <button class='btn btn-primary' wire:click="$dispatch('open-addTask')" data-bs-toggle="tooltip" title="Ajouter une tache">
        <i class='ti ti-plus'></i> Tache
    </button>

    @component('components.modal', ["id"=>'addTask', 'title' => 'Ajouter une tache'])
        <form class="row" wire:submit="store">
            @include('_form.tache_form')
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-addTask', event => { $('#addTask').modal('show'); }) </script>
        <script> window.addEventListener('close-addTask', event => { $('#addTask').modal('hide'); }) </script>
    @endcomponent
</div>
