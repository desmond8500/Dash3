<div>
    @component('components.layouts.page-header', ['title'=>'Achats', 'breadcrumbs'=>$breadcrumbs])
        <button class="btn btn-primary" wire:click="dispatch('open-addAchat')">
            <i class="ti ti-plus"></i> Achat
        </button>
    @endcomponent

    <div class="row">
        @forelse ($achats as $achat)
            <div class="col-md-3">
                <div class="card">

                </div>
            </div>
        @empty

        @endforelse
    </div>


    @component('components.modal', ["id"=>'addAchat', 'title'=>'Ajouter un Achat'])
        <form class="row" wire:submit="store">
            @include('_form.achat_form')
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-addAchat', event => { $('#addAchat').modal('show'); }) </script>
        <script> window.addEventListener('close-addAchat', event => { $('#addAchat').modal('hide'); }) </script>
    @endcomponent
</div>
