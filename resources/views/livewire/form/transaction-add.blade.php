<div>
    <button class='btn btn-primary' wire:click="dispatch('open-addTransaction')" data-bs-toggle="tooltip" title="Ajouter une transaction">
        <i class='ti ti-plus'></i> Transaction
    </button>

    @component('components.modal', ["id"=>'addTransaction', 'title' => 'Ajouter une transaction', "method"=>"store"])
        <form class="row" wire:submit="store">
            @include('_form.transaction_form')
        </form>
        <script> window.addEventListener('open-addTransaction', event => { window.$('#addTransaction').modal('show'); }) </script>
        <script> window.addEventListener('close-addTransaction', event => { window.$('#addTransaction').modal('hide'); }) </script>
    @endcomponent
</div>
