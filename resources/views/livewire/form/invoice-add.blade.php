<div>
    <a class="btn btn-primary btn-pill" wire:click="ajouter()">
        <i class="ti ti-plus"></i>Devis
    </a>

    @component('components.modal', ["id"=>'addInvoice', 'title'=>'Ajouter un devis'])
        <form class="row" wire:submit="store">
            @include('_form.invoice_form')
        </form>

        <script> window.addEventListener('open-addInvoice', event => { $('#addInvoice').modal('show'); }) </script>
        <script> window.addEventListener('close-addInvoice', event => { $('#addInvoice').modal('hide'); }) </script>
    @endcomponent

</div>
