<div>
    <button class='btn btn-primary' wire:click="dispatch('open-addSysteme')"><i class='ti ti-plus'></i> Système</button>

    @component('components.modal', ["id"=>'addSysteme', 'title' => 'Ajouter un système'])

        <form class="row" wire:submit="store">
            @include('_form.systeme_form')
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-addSysteme', event => { window.$('#addSysteme').modal('show'); }) </script>
        <script> window.addEventListener('close-addSysteme', event => { window.$('#addSysteme').modal('hide'); }) </script>
    @endcomponent
</div>

