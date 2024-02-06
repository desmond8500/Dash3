<div>
    <button class='btn btn-primary' wire:click="dispatch('open-addStage')"><i class='ti ti-plus'></i> Niveau</button>

    @component('components.modal', ["id"=>'addStage', 'title' => 'Ajouter un niveau'])
        <form class="row" wire:submit="store">

            @include('_form.stage_form')

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>

        </form>
        <script> window.addEventListener('open-addStage', event => { $('#addStage').modal('show'); }) </script>
        <script> window.addEventListener('close-addStage', event => { $('#addStage').modal('hide'); }) </script>
    @endcomponent
</div>
