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
        @include('_card.invoice_card')
    @empty
        @component('components.no-result', ['description'=>'Veuillez ajouter un devis à ce projet'])

        @endcomponent
    @endforelse


</div>
