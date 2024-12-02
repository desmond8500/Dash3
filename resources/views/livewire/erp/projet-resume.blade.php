<div class="row  g-2">
    <div class="col-md-4">
        {{-- Résumé --}}
        <div class="border rounded">
            <div class="bg-primary text-uppercase fw-bold text-white p-1">Résumé</div>
            <div class="m-2">@parsedown($projet->description)</div>
        </div>

        {{-- Taches --}}
        <div class="card p-2 my-2">
            <div class="row">
                <div class="col">
                    <h2>Taches </h2>
                </div>
                <div class="col-auto">
                    @livewire('form.task-add', ['projet_id' => $projet->id])
                </div>
                <div class="col-12">
                    @component('components.chartjs',[
                    'labels' => [
                    "Nouvelles (".$projet->tasks->where('statut_id', 1)->count().")",
                    "En cours (".$projet->tasks->where('statut_id', 2)->count().")",
                    "En pause (".$projet->tasks->where('statut_id', 3)->count().")",
                    "Terminés (".$projet->tasks->where('statut_id', 4)->count().")",
                    "Annulés (".$projet->tasks->where('statut_id', 5)->count().")",
                    ],
                    'data' => [
                    $projet->tasks->where('statut_id', 1)->count(),
                    $projet->tasks->where('statut_id', 2)->count(),
                    $projet->tasks->where('statut_id', 3)->count(),
                    $projet->tasks->where('statut_id', 4)->count(),
                    $projet->tasks->where('statut_id', 5)->count(),
                    ],
                    ])
                    @endcomponent
                </div>
            </div>
        </div>

        {{-- Batiments --}}
        <div class="card p-2 mb-2">
            <div class="card-title">Batiments</div>
            @foreach ($buildings as $building)
                <a href="{{ route('building',['building_id'=> $building->id]) }}" class="card p-1 mb-1" target="_blank">
                    {{ $building->name }}
                </a>
            @endforeach
        </div>
    </div>
    <div class="col-md-8">
        {{-- Resumé --}}
        <div class="border rounded p-2">
            <div class="row">
                <div class="col-auto">
                    <img class="avatar avatar-md" src="{{ asset($projet->client->avatar) }}" alt="A">
                </div>
                <div class="col">
                    <div class="text-center">
                        <div class="fw-bold" style="font-size: clamp(0.8rem, 2vw, 3rem);">RESUME DU PROJET</div>
                        <div class="text-muted">{{ $projet->name }}</div>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="dropdown open">
                        <button class="btn btn-action border dropdown-toggle" type="button" id="triggerId"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ti ti-dots-vertical"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="triggerId">
                            <button class="dropdown-item" wire:click="edit('{{ $projet->id }}')">Editer</button>
                        </div>
                    </div>
                </div>
            </div>
            <ul class="list-group list-group-flush mt-2">
                <li class="py-1 border-bottom d-flex justify-content-between">
                    <div class="fw-bold">CLIENT</div>
                    <div class="text-muted">{{ $projet->client->name }}</div>
                </li>
                <li class="py-1 border-bottom d-flex justify-content-between">
                    <div class="fw-bold">PROJET</div>
                    <div class="text-muted">{{ $projet->name }}</div>
                </li>
                @if ($projet->start_date)
                    <li class="py-1 border-bottom d-flex justify-content-between">
                        <div class="fw-bold">DATE DE DEBUT</div>
                        <div class="text-muted">{{ $projet->start_date ?? 'NA' }}</div>
                    </li>
                @endif
                @if ($projet->end_date)
                    <li class="py-1 border-bottom d-flex justify-content-between">
                        <div class="fw-bold">DATE DE FIN</div>
                        <div class="text-muted">{{ $projet->end_date ?? 'NA' }}</div>
                    </li>
                @endif
            </ul>

        </div>

        {{-- Devis --}}
        <div class="mt-2">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Devis</div>
                    <div class="card-actions">
                        <div class="btn-list">
                            <div class="input-icon mb-2">
                                <input type="text" class="form-control form-control-rounded" wire:model.live="invoice_search" placeholder="Chercher">
                                <span class="input-icon-addon">
                                    <i class="ti ti-search"></i>
                                </span>
                            </div>
                            @livewire('form.invoice-add', ['projet_id' => $projet->id], key($projet->id))

                        </div>
                    </div>

                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="sticky-top">
                            <tr>
                                <th style="width:10px">#</th>
                                <th style="width:100px">Références</th>
                                <th>Description</th>
                                <th style="width: 90px">statut</th>
                                <th class="text-end" style="width: 120px">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices as $key => $invoice)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>
                                    <a href="{{ route('invoice',['invoice_id'=>$invoice->id]) }}" target="_blank">
                                        {{ ucfirst($invoice->reference) }}
                                    </a>
                                </td>
                                <td>{{ $invoice->description }}</td>
                                <td>{{ $invoice->statut }}</td>
                                <td class="text-end">{{ number_format($invoice->total(), 0,'.', ' ') }} CFA</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{ $invoices->links() }}
                </div>
            </div>
        </div>
    </div>

    @component('components.modal', ["id"=>'editProjet', 'title'=> 'Editer un projet'])
    <form class="row" wire:submit="update">
        @include('_form.projet_form')
    </form>
    <script> window.addEventListener('open-editProjet', event => { $('#editProjet').modal('show'); }) </script>
    <script> window.addEventListener('close-editProjet', event => { $('#editProjet').modal('hide'); }) </script>
    @endcomponent

</div>