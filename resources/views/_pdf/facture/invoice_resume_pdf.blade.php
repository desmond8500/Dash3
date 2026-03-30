<!DOCTYPE html>
<html lang="fr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/table.css">
    <link rel="stylesheet" href="css/pdf.css">
    <link rel="stylesheet" href="css/text.css">
    <link rel="stylesheet" href="css/margin.css">
    <link rel="stylesheet" href="css/facture_pdf.css">
    <title>Resumé factures</title>
</head>

<body>
    <h1>Factures {{ $year }}</h1>

    <table class="table" style="width: 100%; margin-bottom: 20px;">
        <thead>
            <tr>
                <th  class="text-center" width="10">#</th>
                <th width="150">Client/projet</th>
                <th>Devis</th>
                <th>Total</th>
                <th>Date</th>
                <th>Acomptes</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoices as $key => $invoice)
                <tr>
                    <td class="text-center">{{ $key+1 }}</td>
                    <td >
                        <div class="fw-bold">{{ $invoice->projet->client->name }}</div>
                        <div>{{ $invoice->projet->name }}</div>
                    </td>
                    <td>
                        <a href="{{ route('facture_pdf',['invoice_id'=>$invoice->id, 'type' => 'Facture']) }}" target="_blank" class="text-primary fw-bold">
                            #{{ $invoice->reference }}
                        </a>
                        <div>{!! $invoice->description !!}</div>
                    </td>
                    <td align="right" width="70">{{ number_format($invoice->total() , 0,'.', ' ')}} F</td>
                    {{-- <td>{{ $invoice->paydate ?? 'NA' }}</td> --}}
                    <td width="65">
                        @if ($invoice->paydate)
                            {{ $invoice->dateFormat($invoice->paydate) }}
                        @else
                            NA
                        @endif
                    </td>
                    <td width="150">
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
                </tr>
            @endforeach
        </tbody>
    </table>

    <h1>Acomptes {{ $year }}</h1>
    <table class="table" style="width: 100%; margin-bottom: 20px;">
        <thead>
            <tr>
                <th  class="text-center">#</th>
                <th width="150">Client/projet</th>
                <th>Devis</th>
                <th>Total</th>
                <th>Date</th>
                <th>Acomptes</th>
            </tr>
        </thead>
        <tbody>
            @foreach($acomptes as $key => $invoice)
                <tr >
                    <td width="10" class="text-center">{{ $key+1 }}</td>
                    <td >
                        <div class="fw-bold">{{ $invoice->projet->client->name }}</div>
                        <div>{{ $invoice->projet->name }}</div>
                    </td>
                    <td>
                        <a href="{{ route('facture_pdf',['invoice_id'=>$invoice->id, 'type' => 'Acompte']) }}" target="_blank" class="text-primary fw-bold">
                            #{{ $invoice->reference }}
                        </a>
                        <div>{!! $invoice->description !!}</div>
                    </td>
                    <td align="right" width="70">{{ number_format($invoice->total() , 0,'.', ' ')}} F</td>
                    {{-- <td>{{ $invoice->paydate ?? 'NA' }}</td> --}}
                    <td width="65">
                        @if ($invoice->paydate)
                            {{ $invoice->dateFormat($invoice->paydate) }}
                        @else
                            NA
                        @endif
                    </td>
                    <td width="150">
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
                </tr>
            @endforeach
        </tbody>
    </table>


</body>

</html>
