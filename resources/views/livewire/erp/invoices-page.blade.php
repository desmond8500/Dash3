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

    <div class="row g-2">
        @foreach ($invoices->sortByDesc() as $invoice)
            @include('_card.invoice_card')
        @endforeach
    </div>
</div>