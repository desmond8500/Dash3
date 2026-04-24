<?php

use Livewire\Volt\Component;
use App\Models\Invoice;

new class extends Component {
    public $invoice_id;
    public $title;

    public function mount($invoice_id)
    {
        $this->invoice = Invoice::findOrFail($invoice_id);
    }

    function with()
    {
        return [ 'invoice' => $this->invoice, ];
    }

}; ?>

<div>
    <div class="mt-2 border rounded p-2">
        <div class="row align-items-center">
            <div class="col-auto">
                {{-- <img src="{{ public_path($invoice->projet->client->avatar) }}" alt="Logo" style="max-width: 100px;"> --}}
                <img src="{{ public_path('img/tyto/logo.png') }}" alt="logo" style="max-width: 80px;">
            </div>

            <div class="col-md">
                <h1>TYTO SERVICES</h1>
            </div>

            <div class="col-auto text-end">
                <h1 class="">{{ strtoupper($title) }}</h1>
                <div class="text-primary">
                    #{{ $invoice->reference }}
                </div>
                <div class="fs-5 text-secondary" data-bs-toggle="tooltip" title="Date de création"> {{
                    $invoice->dateFormat($invoice->created_at) }}
                </div>
                <div class="" style="font-size: 13px; font-weight:normal;">
                    @if($invoice->paydate)
                    <div class="text-purple">{{ $invoice->formatDate($invoice->paydate) }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
