<div>
    @component('components.layouts.page-header', ['title'=>'Liste des devis', 'breadcrumbs'=>$breadcrumbs])
        <div class="row">
            <div class="col  ">
                <div class="input-icon mb-2">
                    <input type="text" class="form-control form-control-rounded" wire:model.live="search" placeholder="Chercher">
                    <span class="input-icon-addon">
                        <i class="ti ti-search"></i>
                    </span>
                </div>
            </div>
            <div class="col-auto text-center ">
                <div class="dropdown open">
                    <button class="btn " type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="ti ti-chevron-down"></i>{{ $statut ? $statut : 'Statut' }}
                    </button>
                    <div class="dropdown-menu" aria-labelledby="triggerId">
                        <a class="dropdown-item" wire:click="$set('statut', 0)"> <i class="ti ti-circle"></i> Tous</a>
                        @foreach ($statuses as $status)
                        <a class="dropdown-item" wire:click="$set('statut', '{{ $status }}')"> <i class="ti ti-circle"></i> {{
                            $status }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endcomponent

    <div class="row g-2">
        <div class="col-md-12">
            <div class="row row-deck g-2">
                @forelse ($invoices->sortByDesc('created_at') as $invoice)
                    <div class="col-md-3">
                        @include('_card.invoice_card')
                    </div>
                @empty
                    <div>Pas de résultat</div>
                @endforelse
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
