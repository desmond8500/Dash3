<div>
    @component('components.layouts.page-header', ['title'=>'Achats', 'breadcrumbs'=>$breadcrumbs])
    <div class="btn-list">

        <button class="btn btn-icon" wire:click='$refresh'><i class="ti ti-reload"></i> </button>
    </div>
    @endcomponent

    <div class="row g-2">
        <div class="col-md-4">
            <div class="input-icon mb-2">
                <input type="text" class="form-control form-control-rounded" wire:model.live="search" placeholder="Chercher">
                <span class="input-icon-addon">
                    <i class="ti ti-search"></i>
                </span>
            </div>
            @foreach ($invoices->sortByDesc('created_at') as $invoice)
                <div class="mb-1">
                    <a href="{{ route('invoice',['invoice_id'=>$invoice->id]) }}" class="text-dark" target="_blank">
                        @include('_card.invoice_card')
                    </a>
                </div>
            @endforeach
            <div>
                {{ $invoices->links() }}
            </div>
        </div>
        <div class="col-md-8">

        </div>
    </div>

</div>
