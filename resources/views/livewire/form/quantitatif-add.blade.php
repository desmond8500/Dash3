<div>
    <button class="btn btn-primary" wire:click="$dispatch('open-addQuantitatif')">
        <i class="ti ti-plus"></i>
        Ajouter un quantitatif
    </button>
    @component('components.modal', ["id"=>'addQuantitatif', 'title'=>'Ajouter un quantitatif', 'refresh'=>1])
        <div class="row g-2">
            <div class="col-md-6">
                @if ($selectedInvoice)
                    <div class="card card-body">
                        <div class="card-title">Quantitatif</div>

                        <div>
                            <div class="fw-bold">#{{ $selectedInvoice->reference }}</div>
                            <div>
                                <div class="col-md-12 mb-3">
                                    <input type="text" class="form-control" wire:model="quantitatif_name" placeholder="description">
                                    @error('quantitatif_name') <span class='text-danger'>{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div>
                                <button class="btn btn-primary" wire:click="quantitatif_store">Ajouter</button>
                            </div>
                            @if ($message)
                                <div class="text-success">
                                    {{ $message }}
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            <div class="{{ $selectedInvoice ? 'col-md-6' : 'col-md-12' }}">
                @foreach ($invoices as $invoice)
                    <div class="card m-1 p-2">
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
        </div>
        <script> window.addEventListener('open-addQuantitatif', event => { window.$('#addQuantitatif').modal('show'); }) </script>
        <script> window.addEventListener('close-addQuantitati', event => { window.$('#addQuantitati').modal('hide'); }) </script>
    @endcomponent
</div>
