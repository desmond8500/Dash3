<div class="card p-2 mb-1">
    <div class="row">
        <div class="col-md-12">
            @if ($transaction->projet_id)
                <ol class="breadcrumb" aria-label="breadcrumbs">
                    <li class="breadcrumb-item " aria-current="page"><a href="{{ route('projet',['projet_id'=>$transaction->projet_id]) }}">Projet</a></li>
                </ol>
            @endif
            @if ($transaction->invoice_id)
                <ol class="breadcrumb" aria-label="breadcrumbs">
                    <li class="breadcrumb-item " aria-current="page"><a href="{{ route('invoice',['invoice_id'=>$transaction->invoice_id]) }}">Devis</a></li>
                </ol>
            @endif
        </div>
        <div class="col">
            <div class="fw-bold">{{ $transaction->objet }}</div>
            <div>@parsedown($transaction->description)</div>
        </div>
        <div class="col-auto">
            <div class="dropdown open">
                <button class="btn btn-action" type="button" id="triggerId" data-bs-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <i class="ti ti-chevron-down"></i>
                </button>
                <div class="dropdown-menu" aria-labelledby="triggerId">
                    <button class="dropdown-item" wire:click="edit('{{ $transaction->id }}')"><i class="ti ti-edit"></i>
                        Editer</button>
                    <button class="dropdown-item text-red" wire:click="delete('{{ $transaction->id }}')"><i
                            class="ti ti-trash"></i> Supprimer</button>
                </div>
            </div>
        </div>
        <div class="w-100"></div>
        <div class="d-flex justify-content-between mt-2">
            <div class="text-muted">{{ $transaction->formatDate() }}</div>
            <div style="font-size: 17px" class="fw-bold {{ $transaction->type=='credit' ? 'text-green' : 'text-red' }}">
                {{ number_format($transaction->montant, 0,'.', ' ') }} F</div>
        </div>
    </div>
</div>
