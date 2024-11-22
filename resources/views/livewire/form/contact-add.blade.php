<div>
    <button class='btn btn-primary btn-pill' wire:click="dispatch('open-addContact')" ><i class='ti ti-plus'></i> Contact</button>

    @component('components.modal', ["id"=>'addContact', 'title' => 'Ajouter un contact'])
        <form class="row" wire:submit="store">
            @include('_form.contact_form')
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-addContact', event => { $('#addContact').modal('show'); }) </script>
        <script> window.addEventListener('close-addContact', event => { $('#addContact').modal('hide'); }) </script>
    @endcomponent
</div>
