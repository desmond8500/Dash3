<div>
    @component('components.layouts.page-header', ['title'=>'Liste des devis', 'breadcrumbs'=>$breadcrumbs])

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
                    @include('_card.invoice_card')
                </div>
            @endforeach

        </div>
        <div class="col-md-8">

        </div>

        <div class="col-md-12">
            {{ $invoices->links() }}
        </div>
    </div>

</div>
