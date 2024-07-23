<div>
    @component('components.layouts.page-header', ['title'=>'Finances', 'breadcrumbs'=>$breadcrumbs])
        @livewire('form.transaction-add')

    @endcomponent

    <div class="row">
        <div class="col-md-4">
            @foreach ($transactions->sortByDesc('created_at') as $transaction)
                <div class="card p-2 mb-1">
                    <div class="row">
                        <div class="col">
                            <div class="fw-bold">{{ $transaction->objet }}</div>
                            <div>@parsedown($transaction->description)</div>
                        </div>
                        <div class="col-auto">
                            <div class="dropdown open">
                                <button class="btn btn-action" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                                    <i class="ti ti-chevron-down"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="triggerId">
                                    <button class="dropdown-item" wire:click="edit('{{ $transaction->id }}')"><i class="ti ti-edit"></i> Editer</button>
                                    <button class="dropdown-item text-red" wire:click="delete('{{ $transaction->id }}')"><i class="ti ti-trash"></i> Supprimer</button>
                                </div>
                            </div>
                        </div>
                        <div class="w-100"></div>
                        <div class="d-flex justify-content-between mt-2">
                            <div class="text-muted">{{ $transaction->formatDate() }}</div>
                            <div style="font-size: 17px" class="fw-bold {{ $transaction->type=='credit' ? 'text-green' : 'text-red' }}">{{ number_format($transaction->montant, 0,'.', ' ') }} F</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="col-md-4">
            TOTAL: {{ $total }}
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
                type: 'pie',
                data: {
                  labels: ['Red', 'Blue', 'green'],
                  datasets: [{
                    label: '# of Votes',
                    data: [1200, 1900, 200],
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
