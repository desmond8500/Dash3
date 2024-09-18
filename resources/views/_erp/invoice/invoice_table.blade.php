<div class="card">
    <div class="card-header">
        <div class="card-title">
            <div>{{ $devis->client_name ?? $devis->projet->client->name.' - '.$devis->projet->name }}</div>
            <div class="text-primary">#{{ $devis->reference }}</div>
            <div class="" style="font-size: 13px; font-weight:normal;">
                <div>{!! nl2br($devis->description) !!}</div>
            </div>
        </div>
        <div class="card-actions">
            <div class="badge mb-1">{{ $devis->statut }}</div>
            <div class="dropdown">
                <a href="#" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">Actions</a>
                <div class="dropdown-menu">
                    <span class="dropdown-header">Devis</span>
                    <a class="dropdown-item text-success" href="#" wire:click="edit({{ $devis->id }})"> <i class="ti ti-edit"></i> Modifier </a>
                    <a class="dropdown-item text-danger" href="#"> <i class="ti ti-trash"></i> Supprimer </a>

                    <div class="dropdown-divider"></div>

                    <span class="dropdown-header">Devis</span>
                    <a class="dropdown-item" target="_blank" href="{{ route('facture_pdf',['invoice_id'=>$devis->id, 'type'=>'devis']) }}"> <i class="ti ti-file-type-pdf"></i> Devis PDF </a>
                    <a class="dropdown-item" target="_blank" href="#"> <i class="ti ti-file-type-pdf"></i> Devis Simple PDF </a>
                    <a class="dropdown-item" target="_blank" href="#"> <i class="ti ti-file-type-pdf"></i> Proforma PDF </a>

                    <div class="dropdown-divider"></div>

                    <span class="dropdown-header">Facture</span>
                    <a class="dropdown-item" target="_blank"
                        href="{{ route('facture_pdf',['invoice_id'=>$devis->id, 'type'=>'facture']) }}"> <i
                            class="ti ti-file-type-pdf"></i> Facture PDF </a>
                    {{-- <a class="dropdown-item" target="_blank"
                        href="{{ route('facture_pdf',['invoice_id'=>$devis->id, 'type'=>" Facture d'acompte"]) }}"> <i
                            class="ti ti-file-type-pdf"></i> Facture d'acompte </a> --}}
                    <a class="dropdown-item" target="_blank" href="#"> <i class="ti ti-file-type-pdf"></i> Facture Simple PDF </a>

                    <div class="dropdown-divider"></div>

                    <span class="dropdown-header">Exporter</span>
                    <a class="dropdown-item" target="_blank" href="{{ route('facture_pdf',['invoice_id'=>$devis->id, 'type'=>'quantitatif']) }}"> <i class="ti ti-file-type-pdf"></i> Quantitatif PDF </a>
                    <a class="dropdown-item" target="_blank" href="{{ route('invoice_export',['invoice_id'=>$devis->id]) }}"> <i class="ti ti-file-type-pdf"></i> Exporter Quantitatif XLS </a>
                </div>
            </div>

        </div>
    </div>

    <div class="table-responsive">
        <table class="table ">
            <thead>
                <tr>
                    <th scope="col">Désignation</th>
                    <th scope="col" class="text-center">Quantité</th>
                    <th scope="col" class="text-center">Coef</th>
                    <th scope="col" class="text-center">Prix</th>
                    <th scope="col" class="text-center">Total</th>
                    <th scope="col" class="text-center">Marge</th>
                    <th scope="col" style="width: 100px" class="text-center">_</th>
                </tr>
            </thead>
            @php
                $total = 0;
                $total_marge = 0;
            @endphp
            @foreach ($sections as $key => $section)
            @php
                $subtotal = 0;
            @endphp
            <tr>
                <th scope="col" class="bg-primary-lt" colspan="2">
                    <div> <span class='text-danger'>{{ $section->id }}</span> {{ $section->section }}</div>
                </th>
                <th scope="col" class="bg-primary-lt " colspan="6">
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-sm p-1 rounded btn-primary me-1" wire:click="addRow('{{ $section->id }}')">
                            <i class="ti ti-plus"></i> Article
                        </button>
                        <button class="btn btn-sm p-1 rounded btn-primary btn-icon me-1" wire:click="edit_section('{{ $section->id }}')">
                            <i class="ti ti-edit"></i>
                        </button>
                        <button class="btn btn-sm p-1 rounded btn-danger btn-icon me-1" wire:click="delete_section('{{ $section->id }}')"
                            wire:confirm="Etes vous sur de vouloir supprimer cette section ?">
                            <i class="ti ti-trash"></i>
                        </button>
                        <button class="btn btn-sm p-1 btn-primary rounded" disabled>PDF</button>
                    </div>
                </th>
            </tr>

            <tbody>

                @foreach ($section->rows as $row)
                @php
                $total += $row->quantite*$row->prix;
                $total_marge += $row->quantite*$row->coef*$row->prix;
                $subtotal += $row->quantite*$row->coef*$row->prix;
                @endphp
                <tr class="">
                    <td scope="row">
                        <div>{{ $row->designation }}</div>
                        <div class="text-muted">{!! nl2br($row->reference) !!}</div>
                    </td>
                    <td class="text-center">{{ $row->quantite }}</td>
                    <td class="text-center">{{ $row->coef }}</td>
                    <td class="text-center">
                        <div>{{ number_format($row->prix*$row->coef, 0,'.', ' ') }}</div>
                        <div class="text-muted">{{ number_format($row->prix, 0,'.', ' ') }}</div>
                    </td>
                    <td class="text-center">
                        <div>{{ number_format($row->prix*$row->quantite*$row->coef, 0,'.', ' ') }}</div>
                        <div class="text-muted">{{ number_format($row->prix*$row->quantite, 0,'.', ' ') }}</div>
                    </td>
                    <td class="text-center">
                        <div></div>
                        <div>{{ number_format($row->prix*$row->quantite*$row->coef -$row->prix*$row->quantite , 0,'.', '
                            ') }}</div>
                    </td>
                    <td class="text-center ">
                        <div>
                            <button class="btn  btn-icon btn-outline-success" wire:click="editRow('{{ $row->id }}')"><i
                                    class="ti ti-edit"></i></button>
                            <button class="btn btn-icon btn-outline-danger" wire:click="deleteRow('{{ $row->id }}')"><i
                                    class="ti ti-trash"></i></button>
                        </div>
                    </td>
                </tr>
                @endforeach
                <tr class="fw-bold">
                    <td colspan="2">Sous Total</td>
                    <td colspan="5" class="text-end"> {{ number_format($subtotal, 0,'.', ' ') }} F</td>
                </tr>
            </tbody>

            @endforeach
            <tr>
                <th scope="col" class="bg-primary-lt " colspan="8">
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-primary" wire:click="addSection()">
                            <i class="ti ti-plus"></i> Ajouter une section
                        </button>
                    </div>
                </th>
            </tr>
        </table>
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col">

            </div>
            <div class="col-auto">
                <div class="d-flex justify-content-between">
                    <div class="fw-bold me-3">TOTAL HT:</div>
                    <div>{{ number_format($total, 0,'.', ' ') }} F</div>
                </div>
                <div class="d-flex justify-content-between">
                    <div class="fw-bold me-3">MARGE:</div>
                    <div>{{ number_format($total_marge - $total, 0,'.', ' ') }} F</div>
                </div>
                <div class="d-flex justify-content-between">
                    <div class="fw-bold me-3">TOTAL TTC:</div>
                    <div>{{ number_format($total_marge, 0,'.', ' ') }} F</div>
                </div>
            </div>
        </div>
    </div>
</div>
