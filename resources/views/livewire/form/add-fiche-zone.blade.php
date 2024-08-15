<div>
    <button class='btn btn-primary' wire:click="$dispatch('open-addZone')" ><i class='ti ti-plus'></i> Zone</button>

    @component('components.modal', ["id"=>'addZone', 'title' => 'Ajouter une zone'])
        <form class="row" wire:submit="store">
            @include('_form.fiche_zone_form')
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-addZone', event => { $('#addZone').modal('show'); }) </script>
        <script> window.addEventListener('close-addZone', event => { $('#addZone').modal('hide'); }) </script>
    @endcomponent
</div>
