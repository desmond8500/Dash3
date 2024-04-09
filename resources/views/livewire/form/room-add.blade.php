<div>
    <button class='btn btn-primary' wire:click="dispatch('open-addRoom')"><i class='ti ti-plus'></i> Local</button>

    @component('components.modal', ["id"=>'addRoom', 'title' => 'Ajouter un local'])
        @slot('actions')
            @if ($tab)
                <button class="btn btn-primary" wire:click="select('tab')">Générer</button>
            @else
                <button class="btn btn-primary" wire:click="select('tab')">Nouveau</button>
            @endif
        @endslot
        @if ($tab)

        @else
            <form class="row" wire:submit="store">
                @include('_form.room_form')
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Valider</button>
                </div>
            </form>
            <script> window.addEventListener('open-addRoom', event => { $('#addRoom').modal('show'); }) </script>
            <script> window.addEventListener('close-addRoom', event => { $('#addRoom').modal('hide'); }) </script>
        @endif
    @endcomponent
</div>
