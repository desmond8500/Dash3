<div class="card p-2 border-secondary">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex">
                <div class="border-bottom pb-1 mb-1">
                    <span class="text-primary">{{ $invoice->projet->client->name }}</span> / <span class="text-purple">{{ $invoice->projet->name }}</span>
                </div>
                {{-- <button class="btn btn-primary btn-icon">
                    <i class="ti ti-eye"></i>
                </button> --}}
            </div>
        </div>

        <div class="col">
            <a href="{{ route('invoice',['invoice_id'=>$invoice->id]) }}" class="text-dark" target="_blank" wire:navigate>
                <h4 style="text-transform: uppercase">{{ $invoice->reference }}</h4>
            </a>
        </div>
        <div class="col-auto">
            @component('components.status',['status'=>$invoice->statut, 'invoice_id'=> $invoice->id, 'statuses'=>$statuses])

            @endcomponent
        </div>

        <div class="col-md-12 mb-1">
            {{ nl2br($invoice->description) }}
        </div>
        <div class="col-md-6"> <i class="ti ti-calendar"></i> {{ date_format($invoice->created_at, "d-m-Y") }} </div>
        <div class="col-md-6 text-end text-indigo fw-bold fs-3">{{ number_format($invoice->total(), 0,'.', ' ') }} F</div>
    </div>
</div>
