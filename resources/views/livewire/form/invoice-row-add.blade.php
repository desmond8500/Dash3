<div class="text-dark">
    <a class="btn btn-primary" wire:click="addArticle('{{ $invoice_section_id }}')">
        <i class="ti ti-plus"></i>Article {{ $invoice_section_id }}
    </a>

    @component('components.modal', ["id"=>'invoiceRowAdd', 'title'=>'Ajouter un article'])
        <form class="row" wire:submit="store">
            @include('_form.invoice_row_form')
        </form>

        <script> window.addEventListener('open-invoiceRowAdd', event => { $('#invoiceRowAdd').modal('show'); }) </script>
        <script> window.addEventListener('close-invoiceRowAdd', event => { $('#invoiceRowAdd').modal('hide'); }) </script>
    @endcomponent
</div>
