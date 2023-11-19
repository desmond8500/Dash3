<div>
    @component('components.layouts.page-header', ['title'=> 'Dashboard'])

    @endcomponent

    <button class="btn btn-primary" wire:click="$dispatch('open-addModal')">Button</button>

    @component('components.modal', ["id"=>'addModal', 'method'=>'close'])
        <form class="row" wire:submit="register">

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-addModal', event => { $('#addModal').modal('show'); }) </script>
        <script> window.addEventListener('close-addModal', event => { $('#addModal').modal('hide'); }) </script>
    @endcomponent


</div>
