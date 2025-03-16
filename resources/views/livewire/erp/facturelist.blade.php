<div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">Factures</div>
            <div class="card-actions">
                <button class="btn btn-primary btn-icon" wire:click="$dispatch('open-addFacture')" data-bs-toggle="tooltip"
                    title="Ajouter une facture">
                    <i class="ti ti-plus"></i>
                </button>
            </div>
        </div>
        <div class="p-2">
            @forelse ($factures as $facture)
                <div class="card rounded mb-1 p-1">
                    <div class="row align-items-center">
                        @if ($facture->folder)
                            <a class="col" href="{{ asset($facture->folder) }}" target="_blank">
                                <div style="font-size:10px; " class="text-primary">{{ ucfirst($facture->status )}}</div>
                                <div class="text-dark">{{ $facture->description }}</div>
                            </a>
                        @else
                            <a class="col" href="{{ route('facture_pdf',['invoice_id'=>$facture->invoice_id, 'type'=>'facture'])}}" target="_blank">
                                <div style="font-size:10px; " class="text-primary">{{ ucfirst($facture->status )}}</div>
                                <div class="text-dark">{{ $facture->description }}</div>
                            </a>

                        @endif
                        <div class="col-auto">
                            <button class="btn btn-primary btn-icon" wire:click="edit('{{ $facture->id }}')">
                                <i class="ti ti-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-icon" wire:click="delete('{{ $facture->id }}')">
                                <i class="ti ti-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-muted">Aucune facture</div>
            @endforelse

        </div>
    </div>

    @component('components.modal', ["id"=>'addFacture', 'title' => 'Ajouter une facture'])
    <form class="row" wire:submit="store">
        @include('_form.facture_form')
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            <button type="submit" class="btn btn-primary">Valider</button>
        </div>
    </form>
    <script>
        window.addEventListener('open-addFacture', event => { window.$('#addFacture').modal('show'); })
    </script>
    <script>
        window.addEventListener('close-addFacture', event => { window.$('#addFacture').modal('hide'); })
    </script>
    @endcomponent

    @component('components.modal', ["id"=>'editFacture', 'title' => 'Editer une facture'])
    <form class="row" wire:submit="update">
        @include('_form.facture_form')
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            <button type="submit" class="btn btn-primary">Valider</button>
        </div>
    </form>
    <script>
        window.addEventListener('open-editFacture', event => { window.$('#editFacture').modal('show'); })
    </script>
    <script>
        window.addEventListener('close-editFacture', event => { window.$('#editFacture').modal('hide'); })
    </script>
    @endcomponent
</div>
