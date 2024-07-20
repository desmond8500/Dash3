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
           @livewire('form.invoice-add', ['projet_id' => $projet_id], key($projet_id))
        </div>
    </div>

    @forelse ($invoices as $invoice)
        <a href="{{ route('invoice',['invoice_id'=>$invoice->id]) }}" class="col-md-4 text-dark">
            <div class="card p-2 border-secondary">
                <div class="row">
                    <div class="col">
                        <h4 style="text-transform: uppercase">{{ $invoice->reference }}</h4>
                    </div>
                    <div class="col-auto">
                        @component('components.status',['status'=>$invoice->statut])

                        @endcomponent
                    </div>
                    <div class="col-md-12 mb-3">
                        {{ nl2br($invoice->description) }}
                    </div>
                    <div class="col-md-6"> {{ date_format($invoice->created_at, "d-m-Y") }} </div>
                    <div class="col-md-6 text-end">{{ number_format($invoice->total(), 0,'.', ' ') }} F</div>
                </div>
            </div>
        </a>
    @empty
        @component('components.no-result', ['description'=>'Veuillez ajouter un devis à ce projet'])

        @endcomponent
    @endforelse


</div>
