<div class="row  g-2">
    <div class="col-md-4">
        <div class="border rounded">

            <div class="bg-primary text-uppercase fw-bold text-white p-1">Résumé</div>
            <p class="mt-2 p-2">{{ nl2br($projet->description) }}</p>
        </div>

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
    </div>
    <div class="col-md-8">
        <div class="border rounded p-2">
            <div class="row">
                <div class="col-auto">
                    <img class="avatar avatar-md" src="{{ asset($projet->client->avatar) }}" alt="A">
                </div>
                <div class="col">
                    <div class="text-center">
                        <div class="fw-bold" style="font-size:1.5rem;">RESUME DU PROJET</div>
                        <div class="text-muted">{{ $projet->name }}</div>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="dropdown open">
                        <button class="btn btn-action border dropdown-toggle" type="button" id="triggerId" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
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
                <li class="py-1 border-bottom d-flex justify-content-between">
                    <div class="fw-bold">DATE DE DEBUT</div>
                    <div class="text-muted">{{ $projet->start_date ?? 'NA' }}</div>
                </li>
                <li class="py-1 border-bottom d-flex justify-content-between">
                    <div class="fw-bold">DATE DE FIN</div>
                    <div class="text-muted">{{ $projet->end_date ?? 'NA' }}</div>
                </li>
            </ul>

        </div>

        {{-- <div class="border p-2 rounded mt-2">
            <div class="d-flex justify-content-evenly ">
                <div class="btn">Etude</div>
                <div class="btn">Devis</div>
                <div class="btn">Execution</div>
                <div class="btn">Réception</div>
                <div class="btn">Facturation</div>
                <div class="btn">Terminé</div>
            </div>
        </div> --}}

        <div class="mt-2">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Devis</div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="sticky-top">
                            <tr>
                                <th>#</th>
                                <th>Références</th>
                                <th>Description</th>
                                <th>statut</th>
                                <th>Total</th>
                                {{-- <th>Actions</th> --}}
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
                                    <td>{{ number_format($invoice->total(), 0,'.', ' ') }} CFA</td>
                                    {{-- <td></td> --}}
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

</div>
