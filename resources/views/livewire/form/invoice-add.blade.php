<div>
    <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addInvoice">
        <i class="ti ti-plus"></i>Devis
    </a>
    {{-- <a class="btn btn-primary" wire:click="$dispatch('open-initInvoice')">
        <i class="ti ti-plus"></i>Générer Devis
    </a> --}}

    @component('components.modal', ["id"=>'addInvoice', 'title'=>'Ajouter un devis'])
        <form class="row" wire:submit="store">
            @include('_form.invoice_form')
        </form>

        <script>
            window.addEventListener('open-addInvoice', event => { $('#addInvoice').modal('show'); })
        </script>
        <script>
            window.addEventListener('close-addInvoice', event => { $('#addInvoice').modal('hide'); })
        </script>
    @endcomponent

</div>
