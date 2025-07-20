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
        </div>
        <div class="col-md-12">
            <div class="row row-deck g-2">
                @foreach ($invoices->sortByDesc('created_at') as $invoice)
                    <div class="col-md-3">
                        @include('_card.invoice_card')
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-md-12">
            {{ $invoices->links() }}
        </div>
    </div>

    {{-- Invoice --}}
    @component('components.modal', ["id"=>'editInvoice', 'title'=>'Editer un devis', 'method'=>'update_invoice'])
    <form class="row" wire:submit="update_invoice">
        @include('_form.invoice_form',['nosection'=>false])
    </form>

    <script>
        window.addEventListener('open-editInvoice', event => { window.$('#editInvoice').modal('show'); })
    </script>
    <script>
        window.addEventListener('close-editInvoice', event => { window.$('#editInvoice').modal('hide'); })
    </script>
    @endcomponent

</div>
