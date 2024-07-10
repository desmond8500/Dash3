<!DOCTYPE html>
<html lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/table.css">
    <link rel="stylesheet" href="css/pdf.css">
    <link rel="stylesheet" href="css/text.css">
    <link rel="stylesheet" href="css/journal_pdf.css">
    <title>Journal</title>

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
            <td width="80px" class="border_white">
                @if ($logo)
                    <div style="width: 80px; height: 80px;" >
                        <img src="{{ $logo }}" alt="logo" style="width:100%; height:100%;">
                    </div>
                @else
                    <div class="logo"  style="background: #{{ $color1 }}">
                        <div class="text-center" style="padding-top: 30px;">Logo</div>
                    </div>
                @endif
            </td>
            <td width="300px" class="border_white fw-bold" align="left" style="{{ $title_css }}; color: #{{ $color1 }}" >
                <div>{{ env('MAIN_NAME') }}</div>
            </td>
            <td align="right" class="border_white">
                <div class="doc_title" style="text-transform: uppercase; color: #{{ $color1 }} ">{{ $title }}</div>
                {{-- <div><b>{{ $commande->name }}</b></div> --}}
                {{-- <div><i>{{ str_pad($carbon->day,2, '0', STR_PAD_LEFT) }} - {{ str_pad($carbon->month,2, '0', STR_PAD_LEFT) }} - {{ $carbon->year }}</i></div> --}}
                {{-- <i>{{ $journal->formatDate() }}</i> --}}
            </td>
        </tr>
    </table>

    <hr>
    <div>
        <table>
            <tr>
                <td>
                    <div>
                        <span class="fw-bold">Client : </span> <span>{{ $devis->projet->client->name }}</span>
                    </div>
                    <div>
                        <span class="fw-bold">Projet : </span> <span>{{ $devis->projet->name }}</span>
                    </div>

                </td>
                <td>
                    <div class="fw-bold">Description</div>
                    <div>{!! nl2br($devis->description) !!}</div>
                </td>
            </tr>
        </table>

    </div>

    <hr>

    <div class="table-responsive">
        <table class="table ">
            <thead>
                <tr>
                    <th scope="col">Désignation</th>
                    <th style="width:80px;" scope="col" class="text-center">Quantité</th>
                    <th scope="col" class="text-center">Prix</th>
                    <th scope="col" class="text-center">Total</th>
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
                <th scope="col" class="bg-primary-lt" colspan="4">
                    <div>{{ $section->section }}</div>
                </th>

            </tr>

            <tbody style="font-size: 13px;">

                @foreach ($section->rows as $row)
                @php
                    $total += $row->quantite*$row->prix;
                    $total_marge += $row->quantite*$row->coef*$row->prix;
                    $subtotal += $row->quantite*$row->coef*$row->prix;
                @endphp
                <tr class="">
                    <td scope="row" >
                        <div>{{ $row->designation }}</div>
                        <div class="text-muted">{{ nl2br($row->reference) }}</div>
                    </td>
                    <td class="text-center">{{ $row->quantite }}</td>
                    <td class="text-center">
                        <div>{{ number_format($row->prix*$row->coef, 0,'.', ' ') }}</div>
                        {{-- <div class="text-muted">{{ number_format($row->prix, 0,'.', ' ') }}</div> --}}
                    </td>
                    <td class="text-center">
                        <div>{{ number_format($row->prix*$row->quantite*$row->coef, 0,'.', ' ') }}</div>
                        {{-- <div class="text-muted">{{ number_format($row->prix*$row->quantite, 0,'.', ' ') }}</div> --}}
                    </td>

                </tr>
                @endforeach
                <tr class="fw-bold">
                    <td colspan="3">Sous Total</td>
                    <td colspan="1" class="text-end"> {{ number_format($subtotal, 0,'.', ' ') }} F</td>
                </tr>
            </tbody>

            @endforeach

        </table>

        <hr>

        <table class="fw-bold">
            <tr>
                <td>TOTAL HT:</td>
                <td class="text-end">{{ number_format($total_marge, 0,'.', ' ') }} F CFA</td>
            </tr>
            <tr>
                <td>TVA</td>
                <td class="text-end">0 F CFA</td>
            </tr>
            <tr>
                <td>TOTAL TTC:</td>
                <td class="text-end">{{ number_format($total_marge, 0,'.', ' ') }} F CFA</td>
            </tr>
        </table>

        <hr>

        <table>
            <tr class="fw-bold">
                <td><div >Montant Acompte à payer: </div></td>
                <td class="text-end">{{ $acompte }} F CFA</td>
            </tr>
        </table>



    </div>


</body>
</html>
