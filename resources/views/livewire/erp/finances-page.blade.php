<div>
    @component('components.layouts.page-header', ['title'=>'Finances', 'breadcrumbs'=>$breadcrumbs])
        <div class="btn-list">
            @livewire('form.transaction-add')
            <button class="btn btn-icon" wire:click='$refresh'><i class="ti ti-reload"></i> </button>
        </div>
    @endcomponent

    <div class="row">
        <div class="col-md-12">
            <div class="card p-2 mb-3">
                <nav class="nav nav-segmented" role="tablist">
                    <button class="nav-link active" role="tab" data-bs-toggle="tab" aria-selected="true" aria-current="page">
                        Dépenses
                    </button>
                    <button class="nav-link" role="tab" data-bs-toggle="tab" aria-selected="false" tabindex="-1">
                        Factures
                    </button>
                    <button class="nav-link" role="tab" data-bs-toggle="tab" aria-selected="false" tabindex="-1">
                        Redevances
                    </button>
            </div>
            </nav>
        </div>

        <div class="col-md-4">
            <div class="input-icon mb-2">
                <input type="text" class="form-control form-control-rounded" wire:model.live="search" placeholder="Chercher">
                <span class="input-icon-addon">
                    <i class="ti ti-search"></i>
                </span>
            </div>

            @foreach ($transactions->sortByDesc('date') as $transaction)
                @include('_card.transaction_card')
            @endforeach
            <div>
                {{ $transactions->links() }}
            </div>
        </div>

        <div class="col-md-4"></div>

        <div class="col-md-4">
            {{-- <div class="card card-body">
                @component('components.chartjs',[
                'labels' => ["Crédit", "Débit"],
                'data' => [$credit, $debit],
                ])
                @endcomponent
                <div class="display-6 d-flex justify-content-between">
                    <div>TOTAL:</div>
                    <div>{{ number_format($total, 0,'.', ' ') }} F</div>
                </div>
            </div> --}}

        </div>
    </div>

    @component('components.modal', ["id"=>'editTransaction', 'title' => 'Editer une transaction'])
    <form class="row" wire:submit="update">
        @include('_form.transaction_form')
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            <button type="submit" class="btn btn-primary">Valider</button>
        </div>
    </form>
    <script> window.addEventListener('open-editTransaction', event => { window.$('#editTransaction').modal('show'); }) </script>
    <script> window.addEventListener('close-editTransaction', event => { window.$('#editTransaction').modal('hide'); }) </script>
    @endcomponent
</div>
