<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/table.css">
    <title>{{ $achat->name }}</title>
</head>
<body>

    <table class="table" style="margin-bottom: 20px;">
        <tr>
            <td></td>
            <td align="right">
                <div style="font-size: 20px; font-weight: bold">ACHAT</div>
                <div>{{ $achat->name }}</div>
                <div>{{ $achat->date }}</div>
                {{-- <div>{{ date_format($achat->date, 'd-m-Y') }}</div> --}}
            </td>
        </tr>
    </table>



    <table class="table">
        <thead>
            <tr>
                <td align="center" width="20px">#</td>
                <td>Désignation</td>
                <td align="center" width="30px">Quantité</td>
                <td align="center" width="30px">Prix HT/TTC</td>
                <td align="center" width="30px">TVA</td>
                <td align="center" width="30px">Total</td>
            </tr>
        </thead>
        <tbody>
            @php
            $total = 0;
            $tva = 0;
            @endphp
            @foreach ($achat->rows as $key => $row)
            <tr>
                <td align="center">{{ $key+1 }}</td>
                <td>
                    <div><b>{{ $row->designation }}</b></div>
                    <div class="text-muted">{{ $row->reference }}</div>
                </td>
                <td align="center">{{ $row->quantite }}</td>
                <td align="center">
                    <div>{{ number_format($row->prix, 0, 2) }} <span style="font-size: 10px">HT</span> </div>
                    <div class="text-danger">{{ number_format($row->prix + $row->prix * $row->tva, 0, 2)}} <span
                            style="font-size: 10px">TTC</span></div>
                </td>
                <td align="center">
                    @if ($row->tva)
                    <div class="text-light">_</div>
                    <div>{{ $row->tva*100 }}%</div>
                    @endif
                </td>
                <td align="center">
                    <div>{{ number_format($row->prix *$row->quantite, 0, 2) }}</div>
                    <div>{{ number_format(($row->prix + $row->prix * $row->tva)*$row->quantite, 0, 2) }}</div>
                </td>

            </tr>
            @php
            $total+= ($row->prix + $row->prix * $row->tva)*$row->quantite;
            $tva+= $row->prix * $row->tva*$row->quantite;
            @endphp
            @endforeach
        </tbody>
    </table>

    <table style="margin-top: 20px;">
        <tr>
            <td>Total HT</td>
            <td align="right">{{ number_format($achat->total(), 0, 2) }} F CFA</td>
        </tr>
        <tr>
            <td>TVA</td>
            <td align="right">{{ number_format($achat->tva(), 0, 2) }} F CFA</td>
        </tr>
        <tr>
            <td>TOTAL TTC</td>
            <td align="right">{{ number_format($achat->ttc(), 0, 2) }} F CFA</td>
        </tr>
    </table>
</body>
</html>
