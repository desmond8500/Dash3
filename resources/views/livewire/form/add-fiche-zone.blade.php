<div>
    <button class='btn btn-primary' wire:click="add" ><i class='ti ti-plus'></i> Zone</button>

    @component('components.modal', ["id"=>'addZone', 'title' => 'Ajouter une zone', 'refresh'=>true])
        <form class="row" wire:submit="store">
            @include('_form.fiche_zone_form')
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-addZone', event => { window.$('#addZone').modal('show'); }) </script>
        <script> window.addEventListener('close-addZone', event => { window.$('#addZone').modal('hide'); }) </script>
    @endcomponent
</div>
