<div class="row g-2">
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
                            <button class="dropdown-item" wire:click="edit('{{ $projet->id }}')"><i class="ti ti-edit"></i> Editer</button>
                            <button class="dropdown-item" wire:click="favorite()">
                                @if ($projet->favorite)
                                    <span class="text-danger"><i class="ti ti-heart-filled"></i> Favoris</span>
                                @else
                                    <span class="text-muted"><i class="ti ti-heart"></i> Favoris</span>
                                @endif
                            </button>
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
            <div class="my-2">{{ $projet->description }}</div>

        </div>

        {{-- Devis --}}
        <div class="mt-2">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Devis</div>
                    <div class="card-actions">
                        <div class="btn-list">
                            <div class="input-icon mb-2">
                                <input type="text" class="form-control form-control-rounded"
                                    wire:model.live="invoice_search" placeholder="Chercher">
                                <span class="input-icon-addon">
                                    <i class="ti ti-search"></i>
                                </span>
                            </div>
                            {{-- @livewire('form.invoice-add', ['projet_id' => $projet->id]) --}}
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        @if ($invoices->count())
                        <thead class="sticky-top">
                            <tr>
                                <th style="width:5px">#</th>
                                <th style="width:100px">Références</th>
                                <th>Description</th>
                                <th style="width: 120px">statut</th>
                                <th class="text-end" style="width: 130px">Total</th>
                                <th class="text-center" style="width: 10px"></th>
                            </tr>
                        </thead>
                        @endif
                        <tbody>
                            @foreach ($invoices as $key => $invoice)
                                <tr class="cursor-pointer " wire:key="{{ $invoice->id }}">
                                    <td>{{ $key+1 }}</td>
                                    <td>
                                        <a href="{{ route('invoice',['invoice_id'=>$invoice->id]) }}" target="_blank" >
                                            {{ ucfirst($invoice->reference) }}
                                        </a>
                                        @if($invoice->paydate)
                                            <div class="text-purple" data-bs-toggle="tooltip" title="Date de paiement">{{ $invoice->dateFormat($invoice->paydate) }}</div>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $invoice->description }}
                                    </td>
                                    <td>
                                        @component('components.status',['status'=>$invoice->statut, 'invoice_id'=> $invoice->id, 'statuses'=>$statuses])

                                        @endcomponent
                                    </td>
                                    <td class="text-end">
                                        <div>{{ number_format($invoice->total(), 0,'.', ' ') }} F</div>
                                        <div class="text-muted" data-bs-toggle="tooltip" title="Date de création">{{ $invoice->formatDate($invoice->created_at) }}</div>
                                    </td>
                                    <td>
                                        <div class="dropdown open">
                                            <button class="btn btn-action" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                                                <i class="ti ti-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="triggerId">
                                                <a class="dropdown-item" wire:click="dupliquer('{{ $invoice->id }}')"> <i class="ti ti-copy"></i> Dupliquer</a>
                                                <a class="dropdown-item" wire:click="editInvoice('{{ $invoice->id }}')"> <i class="ti ti-edit"></i> Editer</a>
                                                <a class="dropdown-item text-danger" wire:click="delete_invoice('{{ $invoice->id }}')"> <i class="ti ti-trash"></i> Supprimer</a>
                                            </div>
                                        </div>
                                    </td>
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
    <div class="col-md-4">
        {{-- Taches --}}
        <div class="mb-2">
            <h3>Taches</h3>
            @livewire('erp.tasks.tasklist1', ['projet_id'=>$projet->id, 'paginate'=>3])
        </div>

        {{-- Batiments --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title">Batiments</div>
                <div class="card-actions">
                    {{-- @livewire('form.building-add', ['projet_id' => $projet_id], key(1)) --}}
                </div>
            </div>
            @if ($buildings->count())
                <div class="p-2">
                    @foreach ($buildings as $building)
                        <a href="{{ route('building',['building_id'=> $building->id]) }}" class="card p-2 mb-1" target="_blank">
                            {{ $building->name }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>


    @component('components.modal', ["id"=>'editProjet', 'title'=> 'Editer un projet', 'method'=>'update'])
        <form class="row" wire:submit="update">
            @include('_form.projet_form')
        </form>
        <script> window.addEventListener('open-editProjet', event => { window.$('#editProjet').modal('show'); }) </script>
        <script> window.addEventListener('close-editProjet', event => { window.$('#editProjet').modal('hide'); }) </script>
    @endcomponent

</div>
