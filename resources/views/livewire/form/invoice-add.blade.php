<div>
    <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addInvoice">
        <i class="ti ti-plus"></i>Devis
    </a>
    <a class="btn btn-primary" wire:click="$dispatch('open-MintInvoice')">
        <i class="ti ti-plus"></i>Générer Devis
    </a>

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

    @component('components.modal', ["id"=>'MintInvoice', 'title'=>'Ajouter un devis'])
    <form class="row" wire:submit="store">
        {{-- @include('_form.invoice_form') --}}
    </form>

    <script>
        window.addEventListener('open-MintInvoice', event => { $('#MintInvoice').modal('show'); })
    </script>
    <script>
        window.addEventListener('close-MintInvoice', event => { $('#MintInvoice').modal('hide'); })
    </script>
    @endcomponent


    <a class="btn btn-primary" >
        <i class="ti ti-plus"></i>zzz
    </a>
    @component('components.modal', ["id"=>'addModal'])
        <form class="row" wire:submit="register">

            <div class="modal-footer">
                <button type="button" wire:click="$dispatch('close-addModal')">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-addModal', event => { $('#addModal').modal('show'); }) </script>
        <script> window.addEventListener('close-addModal', event => { $('#addModal').modal('hide'); }) </script>
    @endcomponent

</div>
