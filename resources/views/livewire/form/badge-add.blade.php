<div>
    <button class='btn btn-primary' wire:click="dispatch('open-addbadge')" ><i class='ti ti-plus'></i> Badge</button>

    @component('components.modal', ["id"=>'addbadge', 'title' => 'Ajouter un badge'])
        <form class="row" wire:submit="store">
            @include('_form.badge_form')
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-addbadge', event => { $('#addbadge').modal('show'); }) </script>
        <script> window.addEventListener('close-addbadge', event => { $('#addbadge').modal('hide'); }) </script>
    @endcomponent



</div>
