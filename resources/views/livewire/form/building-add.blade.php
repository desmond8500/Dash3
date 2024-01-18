<div>
    <button class='btn btn-primary' wire:click="dispatch('open-addBuilding')"><i class='ti ti-plus'></i> Building</button>

    @component('components.modal', ["id"=>'addBuilding', 'title' => 'Ajouter un batiment'])
    <form class="row" wire:submit="store">

        @include('_form.building_form')

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            <button type="submit" class="btn btn-primary">Valider</button>
        </div>
    </form>
    <script>
        window.addEventListener('open-addBuilding', event => { $('#addBuilding').modal('show'); })
    </script>
    <script>
        window.addEventListener('close-addBuilding', event => { $('#addBuilding').modal('hide'); })
    </script>
    @endcomponent
</div>
