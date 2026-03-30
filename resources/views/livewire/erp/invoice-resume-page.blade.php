<div>
    @component('components.layouts.page-header', ['title'=>'Liste des devis', 'breadcrumbs'=>$breadcrumbs])

        <div class="dropdown open ">
            <button class="btn " type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                <i class="ti ti-chevron-down"></i> Date
            </button>
            <div class="dropdown-menu" aria-labelledby="triggerId">
                <a class="dropdown-item" wire:click="$set('year', 2024)"> 2024 </a>
                <a class="dropdown-item" wire:click="$set('year', 2025)"> 2025 </a>
                <a class="dropdown-item" wire:click="$set('year', 2026)"> 2026 </a>
            </div>
        </div>

    @endcomponent

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Résumé des factures</h3>
        </div>
        <table class="table table-hover">
            <thead class="sticky-top">
                <tr>
                    <td width="25" class="text-center">#</td>
                    <td>Client/projet</td>
                    <td>Devis</td>
                    <td>Total</td>
                    <td>Date</td>
                    <td>Acomptes</td>
                    <td>Actions</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoices as $key => $invoice)
                    <tr>
                        <td class="text-center">{{ $key+1 }}</td>
                        <td style="max-width: 250">
                            <div class="fw-bold">{{ $invoice->projet->client->name }}</div>
                            <div>{{ $invoice->projet->name }}</div>
                        </td>
                        <td>
                            <a href="{{ route('invoice',['invoice_id'=>$invoice->id]) }}" target="_blank" class="text-primary fw-bold">
                                #{{ $invoice->reference }}
                            </a>
                            <div>{!! $invoice->description !!}</div>
                        </td>
                        <td>{{ number_format($invoice->total() , 0,'.', ' ')}} F</td>
                        {{-- <td>{{ $invoice->paydate ?? 'NA' }}</td> --}}
                        <td>
                            @if ($invoice->paydate)
                                {{ $invoice->dateFormat($invoice->paydate) }}
                            @else
                                NA
                            @endif
                        </td>
                        <td>
                            <table>
                                @foreach ($invoice->acomptes as $acompte)
                                    <tr>
                                        <td><span @class($acompte->statut ? 'text-success' : 'text-danger')>{{ number_format($acompte->montant , 0,'.', ' ')}}
                                            F</span>
                                        </td>
                                        <td><span>{{ $acompte->dateFormat($acompte->date) }}</span></td>
                                    </tr>
                                @endforeach
                            </table>
                        </td>
                        <td>
                            <div wire:loading wire:target="compta('{{ $invoice->id }}')">
                                <div class="d-flex justify-content-between">
                                    <div class="btn btn-secondary btn-full">Chargement <span class="animated-dots"></div>
                                </div>
                            </div>
                            <div wire:loading.remove wire:target="compta('{{ $invoice->id }}')">
                                @if ($invoice->comptabilise)
                                    <span class="btn btn-success" wire:click="compta('{{ $invoice->id }}')">Comptabilisé</span>
                                @else
                                    <span class="btn btn-danger" wire:click="compta('{{ $invoice->id }}')">Non comptabilisé</span>
                                @endif
                            </div>

                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    <div class="card mt-2">
        <div class="card-header">
            <h3 class="card-title">Résumé des acomptes</h3>
        </div>
        <table class="table table-hover">
            <thead class="sticky-top">
                <tr>
                    <td width="25" class="text-center">#</td>
                    <td>Client/projet</td>
                    <td>Devis</td>
                    <td>Total</td>
                    <td>Date</td>
                    <td>Acomptes</td>
                    <td>Actions</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($acomptes as $key => $invoice)
                    <tr>
                        <td class="text-center">{{ $key+1 }}</td>
                        <td style="max-width: 250">
                            <div class="fw-bold">{{ $invoice->projet->client->name }}</div>
                            <div>{{ $invoice->projet->name }}</div>
                        </td>
                        <td>
                            <a href="{{ route('invoice',['invoice_id'=>$invoice->id]) }}" target="_blank" class="text-primary fw-bold">
                                #{{ $invoice->reference }}
                            </a>
                            <div>{!! $invoice->description !!}</div>
                        </td>
                        <td>{{ number_format($invoice->total() , 0,'.', ' ')}} F</td>
                        {{-- <td>{{ $invoice->paydate ?? 'NA' }}</td> --}}
                        <td>
                            @if ($invoice->paydate)
                                {{ $invoice->dateFormat($invoice->paydate) }}
                            @else
                                NA
                            @endif
                        </td>
                        <td>
                            <table>
                                @foreach ($invoice->acomptes as $acompte)
                                    <tr>
                                        <td><span @class($acompte->statut ? 'text-success' : 'text-danger')>{{ number_format($acompte->montant , 0,'.', ' ')}}
                                            F</span>
                                        </td>
                                        <td><span>{{ $acompte->dateFormat($acompte->date) }}</span></td>
                                    </tr>
                                @endforeach
                            </table>
                        </td>
                        <td>
                            <div wire:loading wire:target="compta('{{ $invoice->id }}')">
                                <div class="d-flex justify-content-between">
                                    <div class="btn btn-secondary btn-full">Chargement <span class="animated-dots"></div>
                                </div>
                            </div>
                            <div wire:loading.remove wire:target="compta('{{ $invoice->id }}')">
                                @if ($invoice->comptabilise)
                                    <span class="btn btn-success" wire:click="compta('{{ $invoice->id }}')">Comptabilisé</span>
                                @else
                                    <span class="btn btn-danger" wire:click="compta('{{ $invoice->id }}')">Non comptabilisé</span>
                                @endif
                            </div>

                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

</div>
