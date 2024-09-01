<!DOCTYPE html>
<html lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/table.css">
    <link rel="stylesheet" href="css/pdf.css">
    <link rel="stylesheet" href="css/text.css">
    <title>{{ $achat->name }}</title>

</head>
<body>
    @php
        $total = 0;
        $tva = 0;
        $carbon->locale('fr_FR');
        $carbon->create($achat->date)->locale('fr_FR');
    @endphp

    <table class="table" style="margin-bottom: 10px;">
        <tr>
            <td width="150px" class="border_white">
                <div class="logo">
                    <img src="{{ env('LOGO') }}" alt="" class="logo">

                </div>
            </td>
            <td align="right" class="border_white">
                <div class="doc_title">ACHAT</div>
                <div><b>{{ $achat->name }}</b></div>
                <div><i>{{ $carbon->day }} - {{ str_pad($carbon->month,2, '0', STR_PAD_LEFT) }} - {{ $carbon->year }}</i></div>
            </td>
        </tr>
    </table>

    <table class="table">
        <thead class="thead">
            <tr>
                <td align="center" width="20px">#</td>
                <td>Désignation</td>
                <td align="center" width="30px">Quantité</td>
                <td align="center" width="120px">Prix HT/TTC</td>
                <td align="center" width="30px">TVA</td>
                <td align="center" width="40px">Total</td>
            </tr>
        </thead>
        <tbody>

            @foreach ($achat->rows as $key => $row)
            <tr>
                <td align="center" class="fw-bold">{{ $key+1 }}</td>
                <td>
                    <div><b>{{ $row->designation }}</b></div>
                    <div class="text-muted fs-7">{{ $row->reference }}</div>
                </td>
                <td align="center">{{ $row->quantite }}</td>
                <td align="right">
                    <div>{{ number_format($row->prix, 0, 2) }} <span style="font-size: 10px;">HT<span style="color:white">1</span></span> </div>
                    @if ($row->tva)
                        <div class="text-danger">
                            {{ number_format($row->prix + $row->prix * $row->tva, 0, 2)}}
                            <span style="font-size: 10px;">TTC</span>
                        </div>
                    @endif
                </td>
                <td align="right">
                    @if ($row->tva)
                        <div>{{ $row->tva*100 }}%</div>
                    @endif
                </td>
                <td align="center">
                    <div>{{ number_format($row->prix *$row->quantite, 0, 2) }}</div>
                    @if ($row->tva)
                        <div>{{ number_format(($row->prix + $row->prix * $row->tva)*$row->quantite, 0, 2) }}</div>
                    @endif
                </td>

            </tr>
            @php
            $total+= ($row->prix + $row->prix * $row->tva)*$row->quantite;
            $tva+= $row->prix * $row->tva*$row->quantite;
            @endphp
            @endforeach
        </tbody>
    </table>

    <table style="margin-top: 20px; float: right">
        <tr>
            <td style="width: 100px"><b>Total HT</b></td>
            <td align="right" style="width: 170px">{{ number_format($achat->total(), 0, 2) }} F CFA</td>
        </tr>
        <tr>
            <td><b>TVA</b></td>
            <td align="right">{{ number_format($achat->tva(), 0, 2) }} F CFA</td>
        </tr>
        <tr>
            <td><b>TOTAL TTC</b></td>
            <td align="right">{{ number_format($achat->ttc(), 0, 2) }} F CFA</td>
        </tr>
    </table>
</body>
</html>
