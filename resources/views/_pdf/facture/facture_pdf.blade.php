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
    <title>{{ ucfirst($title) }}</title>
</head>
<body>
    @php
        $total = 0;
        $tva = 0;
        $carbon->locale('fr_FR');
    @endphp

    <table class="table" style="">
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
                @if ($title !="quantitatif")
                    <i>#{{ strtoupper($devis->reference) }}</i>
                    @endif
                <i>#{{ strtoupper($devis->date) }}</i>
            </td>
        </tr>
    </table>

    <div class="">
        <table>
            <tr style="border: 1px solid gray" >
                <td class="border-white" width="350px">
                    <div>
                        <span class="fw-bold">Client : </span> <span>{{ $devis->client_name ?? $devis->projet->client->name }}</span>
                    </div>
                    <div>
                        <span class="fw-bold">Projet : </span> <span>{{ $devis->projet->name }}</span>
                    </div>

                </td>
                <td class="border-white">
                    <div class="fw-bold">Description</div>
                    <div>{!! nl2br($devis->description) !!}</div>
                </td>
            </tr>
        </table>

    </div>

    <div class="mt-1">
        <table class="table " >
            <thead style="border-radius: 10px;">
                <tr class="bg-green3 text-white" >
                    <th scope="col" class="text-start">Désignation</th>
                    <th style="width:80px;" scope="col" class="text-center">Quantité</th>
                    @if ($title !="quantitatif")
                        <th style="width: 80px;" scope="col" class="text-center">Prix</th>
                        <th style="width: 100px;" scope="col" class="text-center">Total</th>
                    @endif
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
                <th scope="col" class="bg-green2" colspan="{{ $title !="quantitatif" ? 4 : 2 }}">
                    <div class="facture_section">{{ $section->section }}</div>
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
                            <div class="fw-bold">{{ $row->designation }}</div>
                            <div class="text-muted" style="font-size: 10px;">{!! nl2br($row->reference) !!}</div>
                        </td>
                        <td class="text-center">{{ $row->quantite }}</td>
                        @if ($title !="quantitatif")
                            <td class="text-center">
                                <div>{{ number_format($row->prix*$row->coef, 0,'.', ' ') }}</div>
                                {{-- <div class="text-muted">{{ number_format($row->prix, 0,'.', ' ') }}</div> --}}
                            </td>
                            <td class="text-center">
                                <div>{{ number_format($row->prix*$row->quantite*$row->coef, 0,'.', ' ') }}</div>
                                {{-- <div class="text-muted">{{ number_format($row->prix*$row->quantite, 0,'.', ' ') }}</div> --}}
                            </td>
                        @endif
                    </tr>
                @endforeach
                @if ($title!="quantitatif")
                    <tr class="sous-total">
                        <td colspan="3">Sous Total</td>
                        <td colspan="1" class="text-end"> {{ number_format($subtotal, 0,'.', ' ') }} F</td>
                    </tr>
                @endif
            </tbody>

            @endforeach

        </table>

        @if ($title!="quantitatif")
            @include('_pdf.facture.facture_total_pdf')
        @endif

        @if ($acompte)
            @include('_pdf.facture.facture_acompte_pdf')
        @endif
    </div>

    <div class="footer">
        @include('_pdf.facture.facture_footer_pdf')
    </div>

</body>
</html>
