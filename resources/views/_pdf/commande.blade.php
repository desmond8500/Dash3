<!DOCTYPE html>
<html lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/table.css">
    <link rel="stylesheet" href="css/pdf.css">
    <link rel="stylesheet" href="css/text.css">
    <title>Commandes</title>

</head>
<body>
    @php
        $total = 0;
        $tva = 0;
        $carbon->locale('fr_FR');
        // $carbon->create($commande->date)->locale('fr_FR');
    @endphp

    <table class="table" style="margin-bottom: 10px;">
        <tr>
            <td width="150px" class="border_white">
                <div class="logo">
                    <div>logo</div>

                </div>
            </td>
            <td align="right" class="border_white">
                <div class="doc_title" style="text-transform: uppercase">{{ $title }}</div>
                {{-- <div><b>{{ $commande->name }}</b></div> --}}
                <div><i>{{ str_pad($carbon->day,2, '0', STR_PAD_LEFT) }} - {{ str_pad($carbon->month,2, '0', STR_PAD_LEFT) }} - {{ $carbon->year }}</i></div>
            </td>
        </tr>
    </table>

    <table class="table">
        <thead class="thead">
            <tr>
                <td align="center" width="20px">#</td>
                <td>Désignation</td>
                <td align="center" width="30px">Quantité</td>
                <td align="center" width="120px">Prix</td>
                <td align="center" width="120px">Total</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($commandes as $key => $row)
                <tr>
                    <td align="center" class="fw-bold">{{ $key+1 }}</td>
                    <td>
                        <div><b>{{ $row->article->designation }}</b></div>
                        <div class="text-muted">{{ $row->article->reference }}</div>
                    </td>
                    <td align="center">{{ $row->quantity }}</td>
                    <td align="right">
                        <div>{{ number_format($row->article->price, 0, 2) }} <span style="font-size: 10px;"> CFA<span style="color:white">1</span></span> </div>

                    </td>
                    <td align="center">
                        <div>{{ number_format($row->article->price *$row->quantity, 0, 2) }} CFA</div>
                    </td>

                </tr>
                @php $total+= $row->article->price*$row->quantity; @endphp
            @endforeach
        </tbody>
    </table>

    <table style="margin-top: 20px; float: right">
        <tr>
            <td ><b>Total</b></td>
            <td align="right" style="width: 170px">{{ number_format($total, 0, 2) }} F CFA</td>
        </tr>

    </table>
</body>
</html>
