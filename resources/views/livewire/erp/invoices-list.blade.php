<div class="row g-2">
    <div class="row mt-3">
        <div class="col-md">
            <h2>Liste des devis</h2>
        </div>
        <div class="col-md-auto">
            <div class="input-icon">
                <input type="text" class="form-control form-control-rounded " wire:model="search"
                    placeholder="Trouver un devis">
                <span class="input-icon-addon">
                    <i class="ti ti-search"></i>
                </span>
            </div>
        </div>
        <div class="col-md-auto">
           {{-- @livewire('form.invoice-add', ['projet_id' => $projet_id]) --}}
        </div>
    </div>

    @forelse ($invoices as $invoice)
        <a href="{{ route('invoice',['invoice_id'=>$invoice->id]) }}" class="col-md-4 text-dark">
            @include('_card.invoice_card')
        </a>
    @empty
        @component('components.no-result', ['description'=>'Veuillez ajouter un devis à ce projet'])

        @endcomponent
    @endforelse


</div>
