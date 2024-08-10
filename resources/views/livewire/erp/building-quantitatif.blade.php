<div>
    <div class="row">
        <div class="col">

        </div>
        <div class="col-auto">
            <button class="btn btn-primary" wire:click="$dispatch('open-addQuantitatif')"><i class="ti ti-plus"></i> Ajouter un quantitatif</button>
        </div>
    </div>

    @component('components.modal', ["id"=>'addQuantitatif', 'title'=>'Ajouter un quantitatif', 'refresh'=>1])
    <form class="row" wire:submit="quantitatif_store">
        @if ($selectedInvoice)
            <div class="card card-body">
                <div class="card-title">Quantitatif</div>
                <div class="d-flex">
                    <div class="fw-bold">Référence :</div>
                    <div>{{ $selectedInvoice->reference }}</div>
                </div>
                <div>
                    <div class="fw-bold ">Description :</div>
                    <div>{!! nl2br($selectedInvoice->description) !!}</div>
                </div>
            </div>
        @endif

        <div>
            @foreach ($invoices as $invoice)
                <div class="card m-1 card-body" >
                    <div class="row">
                        <div class="col">
                            <div class="fw-bold">
                                #D-{{ $invoice->reference }}
                            </div>
                            <div class="text-muted">{!! nl2br($invoice->description) !!}</div>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-primary btn-icon" wire:click="selectInvoice('{{ $invoice->id }}')">
                                <i class="ti ti-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            <button type="submit" class="btn btn-primary">Valider</button>
        </div>
    </form>
    <script> window.addEventListener('open-addQuantitatif', event => { $('#addQuantitatif').modal('show'); }) </script>
    <script> window.addEventListener('close-addQuantitati', event => { $('#addQuantitati').modal('hide'); }) </script>
    @endcomponent
</div>
