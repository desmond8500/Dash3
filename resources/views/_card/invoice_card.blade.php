<div class="card p-2 border-secondary">
    <div class="row">
        <div class="col">
            <a href="{{ route('invoice',['invoice_id'=>$invoice->id]) }}" class="text-dark" target="_blank">
                <h4 style="text-transform: uppercase">{{ $invoice->reference }}</h4>
            </a>
        </div>
        <div class="col-auto">
            @component('components.status',['status'=>$invoice->statut, 'invoice_id'=> $invoice->id, 'statuses'=>$statuses])

            @endcomponent
        </div>
        <div class="col-md-12 mb-3">
            {{ nl2br($invoice->description) }}
        </div>
        <div class="col-md-6"> {{ date_format($invoice->created_at, "d-m-Y") }} </div>
        <div class="col-md-6 text-end">{{ number_format($invoice->total(), 0,'.', ' ') }} F</div>
    </div>
</div>
