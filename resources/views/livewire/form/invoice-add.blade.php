<div>
    <a class="btn btn-primary" wire:click="$dispatch('open-addInvoice')">
        <i class="ti ti-plus"></i>Devis
    </a>
    <button class="btn btn-primary">
        <i class="ti ti-plus"></i>Générer Devis
    </button>

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
