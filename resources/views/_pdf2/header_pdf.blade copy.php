<div class="mt-2 border rounded p-2">
    <div class="row ">
        <div class="col-auto">
            <img src="{{ public_path($invoice->projet->client->avatar) }}" alt="Logo" style="max-width: 100px;">
        </div>

        <div class="col-md">
            <div class=" fw-bold text-uppercase"> {{ $invoice->projet->client->name }}</div>
            <div class="fw-bold">{{ $invoice->projet->name }}</div>
            <div>{{ $invoice->projet->description }}</div>
        </div>

        <div class="col-auto">
            <h3>INSTALLATIONS</h3>
            <div>
                <div class="text-end">{{ $invoice->projet->updated_at->format('d/m/Y') }}</div>
            </div>
        </div>
    </div>
</div>
