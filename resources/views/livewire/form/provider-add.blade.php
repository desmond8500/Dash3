<div>
    <button class="btn btn-primary" wire:click="$dispatch('open-addProvider')">
        <i class="ti ti-plus"></i>
        F<div class="d-none d-sm-block">ournisseur</div>
    </button>

    @component('components.modal', ["id"=>'addProvider', 'title'=>'Ajouter un fournisseur', "method"=>"store"])
        <form class="row" wire:submit="store">
            @include('_form.provider_form')
        </form>
        <script> window.addEventListener('open-addProvider', event => { window.$('#addProvider').modal('show'); }) </script>
        <script> window.addEventListener('close-addProvider', event => { window.$('#addProvider').modal('hide'); }) </script>
    @endcomponent
</div>
