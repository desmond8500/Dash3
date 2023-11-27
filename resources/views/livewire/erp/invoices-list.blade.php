<div class="row g-3">
    <div class="row mt-3">
        <div class="col-md">
            <h2>Liste des devis</h2>
        </div>
        <div class="col-md-auto">
            <div class="input-icon">
                <input type="text" class="form-control " wire:model="search"
                    placeholder="Trouver un devis">
                <span class="input-icon-addon">
                    <i class="ti ti-search"></i>
                </span>
            </div>
        </div>
        <div class="col-md-auto">
            <button class="btn btn-primary" wire:click="$dispatch">
                <i class="ti ti-plus"></i>Devis
            </button>
            <button class="btn btn-primary">
                <i class="ti ti-plus"></i>Générer Devis
            </button>
        </div>
    </div>

    @forelse ($invoices as $invoice)
        <a href="{{ route('invoice',['invoice_id'=>1]) }}" class="col-md-3 text-dark">
            <div class="card p-2 border-secondary">
                <div class="row">
                    <div class="col">
                        <h4 style="text-transform: uppercase">Référence</h4>
                    </div>
                    <div class="col-auto">
                        <div class="status status-primary">
                            <span class="status-dot"></span>
                            Nouveau
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Asperiores, vero?
                    </div>
                    <div class="col-md-6"> 12/12/2023 </div>
                    <div class="col-md-6 text-end">1 800 000 F</div>
                </div>
            </div>
        </a>
    @empty
        @component('components.no-result', ['description'=>'Veuillez ajouter un devis à ce projet'])

        @endcomponent
    @endforelse

    @component('components.modal', ["id"=>'addInvoice', 'method'=>'close'])
        <form class="row" wire:submit="register">

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-addInvoice', event => { $('#addInvoice').modal('show'); }) </script>
        <script> window.addEventListener('close-addInvoice', event => { $('#addInvoice').modal('hide'); }) </script>
    @endcomponent
</div>
