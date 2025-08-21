<div>
    @component('components.layouts.page-header', ['title'=>'Devis', 'breadcrumbs'=>$breadcrumbs])
        <div class="btn-list">
            <div class="input-icon">
                <input type="text" class="form-control form-control-rounded" wire:model.live="search" placeholder="Chercher">
                <span class="input-icon-addon">
                    <i class="ti ti-search"></i>
                </span>
            </div>
            <div class="dropdown open" data-bs-toggle="tooltip" title="Filtrer">
                <button class="btn btn-icon" type="button" id="triggerId"  data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                    <i class="ti ti-filter"></i>
                </button>
                <div class="dropdown-menu" aria-labelledby="triggerId">
                    @foreach ($statuses as $status)
                        <a class="dropdown-item" wire:click="$set('filter' ,'{{ $status->name }}')"> <i class="ti ti-edit"></i> {{ $status->name }}</a>
                    @endforeach
                </div>
            </div>
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
