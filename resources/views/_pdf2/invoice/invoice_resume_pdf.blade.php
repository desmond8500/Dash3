<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/css/tabler.min.css" />

    <title>Resumé de devis</title>
</head>

<body class="container">

    @include('_pdf2.invoice.invoice_header_pdf')

    <div class=" mt-2">
        <table class="table table-sm table-bordered">
            <tr class="table-dark">
                <th colspan="2" class="text-uppercase " >
                    Resumé
                </th>

            </tr>
            <tbody>
                <tr>
                    <td>Total Devis</td>
                    <td class="text-end">{{ number_format($invoice->total(), 0,'.', ' ') }} F</td>
                </tr>
                <tr>
                    <td class='bg-green-lt'>Total Acomptes</td>
                    <td class="text-end bg-green-lt">{{ number_format($acomptes->sum('montant'), 0,'.', ' ') }} F</td>
                </tr>
                <tr>
                    <td class='bg-green-lt'>Restant Acompte</td>
                    <td class="text-end bg-green-lt">{{ number_format($acomptes->sum('montant') - $spents->sum('montant'),
                        0,'.', ' ') }} F</td>
                </tr>
                <tr>
                    <td class='bg-red-lt'>Total Dépenses</td>
                    <td class="text-end bg-red-lt">{{ number_format($spents->sum('montant'), 0,'.', ' ') }} F</td>
                </tr>
                <tr>
                    <td class='bg-red-lt'>Reliquat devis</td>
                    <td class="text-end bg-red-lt">{{ number_format($invoice->total() - $acomptes->sum('montant'), 0,'.', ' ') }} F</td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- ========================================================= --}}

    <div class="mt-2">
        <table class="table table-sm table-bordered">
            @if ($invoice->spents->isEmpty())
                <div class="text-center pt-1 text-muted">Aucune dépense</div>
            @else
                <tr class="table-dark text-uppercase" >
                    <th style="text-align:center; width: 5px;">#</th>
                    <th>Acomptes</th>
                    <th style="text-align:center; width: 100px;">Montant</th>
                    <th style="text-align:center; width: 130px;">Date</th>
                </tr>
            @endif
            <tbody>
                @foreach ($invoice->spents as $key => $spent)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>
                            <div>{{ $spent->name }}</div>
                            <div class="text-muted">{!! nl2br($spent->description) !!}</div>
                        </td>
                        <td class="text-end">{{ number_format($spent->montant, 0,'.', ' ') }} F</td>
                        <td class="text-end">
                            <div>{{ $spent->formatDate() }}</div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    {{-- ========================================================= --}}

    <div class="mt-2">
        <table class="table table-sm table-bordered">
            @if ($invoice->acomptes->isEmpty())
                <div class="text-center pt-1 text-muted">Aucun acompte</div>
            @else
                <tr class="table-dark tabler-border text-uppercase">
                    <th style="text-align:center; width: 5px;">#</th>
                    <th>Dépenses</th>
                    <th style="text-align:center; width: 100px;">Montant</th>
                    <th style="text-align:center; width: 120px;">Date</th>
                </tr>
            @endif
            <tbody>
                @foreach ($invoice->acomptes as $key => $acompte)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>
                            <div>{{ $acompte->name }}</div>
                            <div class="text-muted">{!! nl2br($acompte->description) !!}</div>
                        </td>
                        <td class="text-end">{{ number_format($acompte->montant, 0,'.', ' ') }} F</td>
                        <td class="text-end">
                            <div>{{ $acompte->formatDate(null, true) }}</div>
                            <div>
                                @if ($acompte->statut)
                                <span class="text-success">Payé</span>
                                @else
                                <span class="text-danger">Pas Payé</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>

</html>
