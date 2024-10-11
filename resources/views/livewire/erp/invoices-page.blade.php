<div>
    @component('components.layouts.page-header', ['title'=>'Devis', 'breadcrumbs'=>$breadcrumbs])
        <div class="btn-list">
            <div class="input-icon">
                <input type="text" class="form-control form-control-rounded" wire:model.live="search" placeholder="Chercher">
                <span class="input-icon-addon">
                    <i class="ti ti-search"></i>
                </span>
            </div>
            <button class="btn btn-icon" wire:click='$refresh'><i class="ti ti-reload"></i> </button>
        </div>
    @endcomponent

    <div class="row row-deck g-2">
        @foreach ($invoices->sortByDesc('created_at') as $invoice)
            <div class="col-md-4">
                <a href="{{ route('invoice',['invoice_id'=>$invoice->id]) }}" target="_blank">
                    @include('_card.invoice_card')
                </a>
            </div>
        @endforeach
    </div>
</div>
