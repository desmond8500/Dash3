<div>
    <button class="btn btn-primary" wire:click="dispatch('open-addAchat')">
        <i class="ti ti-plus"></i> Achat
    </button>

    @component('components.modal', ["id"=>'addAchat', 'title'=>'Ajouter un Achat', "method"=>"store"])
        <form class="row" wire:submit="store">
            @include('_form.achat_form')
        </form>
        <script> window.addEventListener('open-addAchat', event => { window.$('#addAchat').modal('show'); }) </script>
        <script> window.addEventListener('close-addAchat', event => { window.$('#addAchat').modal('hide'); }) </script>
    @endcomponent
</div>
