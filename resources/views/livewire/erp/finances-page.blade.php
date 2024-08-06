<div>
    @component('components.layouts.page-header', ['title'=>'Finances', 'breadcrumbs'=>$breadcrumbs])
        <div class="btn-list">
            @livewire('form.transaction-add')
            <button class="btn btn-icon" wire:click='$refresh'><i class="ti ti-reload"></i> </button>
        </div>
    @endcomponent

    <div class="row">
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

        <div class="col-md-4">

        </div>

        <div class="col-md-4" wire:ignore>
            <div class="card card-body">
                <canvas id="myChart"></canvas>
                <div class="display-6 d-flex justify-content-between">
                    <div>TOTAL:</div>
                    <div>{{ number_format($total, 0,'.', ' ') }} F</div>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

            <script>
                const ctx = document.getElementById('myChart');

              new Chart(ctx, {
                type: 'doughnut',
                data: {
                  labels: ['Red', 'Blue'],
                  datasets: [{
                    label: '# of Votes',
                    data: [50, 60],
                    borderWidth: 1,
                    legend: 'Résumé des dépenses'
                  }]
                },
                options: {
                  scales: {
                    y: {
                      beginAtZero: true
                    }
                  }
                }
              });
            </script>
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
    <script>
        window.addEventListener('open-editTransaction', event => { $('#editTransaction').modal('show'); })
    </script>
    <script>
        window.addEventListener('close-editTransaction', event => { $('#editTransaction').modal('hide'); })
    </script>
    @endcomponent
</div>
