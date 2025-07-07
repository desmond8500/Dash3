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
                    <div class="logo"  style="background: #{{ $color1 ?? '6b8a7a' }}; border-radius: 5px;">
                        <div class="text-center" style="padding-top: 30px;"></div>
                    </div>
                @endif
            </td>
            <td width="300px" class="border_white fw-bold" align="left" style="{{ $title_css ?? '6b8a7a' }}; color: #{{ $color1 ?? '6b8a7a' }}" >
                <div>{{ env('MAIN_NAME') }}</div>
            </td>
            <td align="right" class="border_white">
                <div class="doc_title" style="text-transform: uppercase; color: #{{ $color1 ?? '6b8a7a'}} ">{{ $title }}</div>
                @if ($title !="quantitatif")
                    <i>#{{ strtoupper($devis->reference) }}</i>
                @endif
                <div>
                    <i class="text-muted">Emis le : {{ ($devis->formatDate()) }}</i>
                </div>
                @if ($devis->facture_date && $title == 'facture')
                    <div>
                        <i class="text-muted">Facturé le : {{ ($devis->formatDate($devis->facture_date)) }}</i>
                    </div>
                @endif
                @if ($devis->paydate && $title == 'facture')
                    <div>
                        <i class="text-muted">Payé le : {{ ($devis->formatDate($devis->paydate)) }}</i>
                    </div>
                @endif
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

    <div class="">
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

                @foreach ($section->rows->sortBy('priorite_id') as $row)
                    @php
                        $total += $row->quantite*$row->prix;
                        $total_marge += $row->quantite*$row->coef*$row->prix;
                        $subtotal += $row->quantite*$row->coef*$row->prix;
                    @endphp
                    <tr @class(['text-danger' => $row->quantite == 0 || $row->prix == 0])>
                        <td scope="row" >
                            <div class="fw-bold">{!! nl2br($row->designation) !!}</div>
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

        <div class="mt-1">
            <table class="table">
                <tr>
                    <td width="@if($devis->note) 50% @endif" class="border-white">
                        @if ($devis->modalite && $title == 'devis')
                            <div class="fw-bold text-underline" style="margin-bottom: 5px;">Modalités :</div>
                            <div>{{ $devis->modalite }}</div>
                        @endif
                    </td>
                    <td class="border-white">
                        @if ($devis->note && $title == 'devis')
                            <div class="fw-bold mt-1 text-underline" style="margin-bottom: 5px;">Notes :</div>
                            <div>{{ $devis->note }}</div>
                        @endif
                    </td>
                </tr>
            </table>
        </div>

        @isset ($acomptes)
            @include('_pdf.facture.facture_acompte_pdf')
        @endisset
    </div>

    @if ($sections)
        @foreach ($sections as $key => $section)

        @if ($section->status)
        <div class="page-break"></div>

            @if ($loop->first)
                 <table  >
                    <tr>
                        <td width="40px" class="text-center border-white">
                            <img src="{{ 'img/icons/writing.png' }}" height="40px" alt="" style="color: green;">
                        </td>

                        <td class="border-white">
                            <div class="doc_title" style="text-transform: uppercase; color: #{{ $color1 }} ">Détails Techniques</div>
                        </td>
                    </tr>
                 </table>

                 <div style="border: 1px solid #219c90;">

                 </div>

            @endif

            <table class="table mt-1">
                <tr>
                    <td colspan="3">
                            <div class="my-0">
                                <div class="fw-bold">{{ $section->section }}</div>
                                <div class="text-muted  " style="font-size: 12px;">{!! $section->proposition !!}</div>
                            </div>

                        </td>

                    </tr>
                    <thead>
                        <tr style="background: #{{ $color1 }}; color: white;">
                            <th scope="col" style="width: 150px;">Photo</th>
                            <th scope="col" class="text-center">Description</th>
                            <th scope="col" style="width: 10px" class="text-center">Quantité</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($section->rows->sortBy('priorite_id') as $row)
                            @if ($row->priorite_id < 5   )
                                <tr >
                                    <td>
                                        @isset ($row->article->image)
                                        <img src="{{ ($row->article->image) }}" style="height: 150px" alt="I" class="avatar avatar-sm me-2">
                                        @else
                                        <img src="{{ ("img/icons/packaging.png") }}" style="height: 150px" alt="I" class="avatar avatar-sm me-2 bg-white border border-white">
                                        @endisset
                                    </td>
                                    <td style="vertical-align: top;">
                                        <div class="mb-1">
                                            @if ($row->article_id)
                                            <a href="{{ route('article',['article_id'=>$row->article_id]) }}" target="_blank">{{
                                                $row->designation }}</a>
                                            @else
                                            {{ $row->designation }}
                                            @endif

                                        </div>
                                        <div class="text-muted" style="font-size: 12px;">{!! nl2br($row->reference) !!}</div>
                                        <hr>

                                        <div style="font-size: 14px;">{!! nl2br($row->article->description ?? ' ') !!}</div>

                                        <div class="mt-1">
                                            @if ($row->article && $row->article->links)
                                                @foreach ($row->article->links as $link)
                                                    @if ($link->name == "Fiche Technique")
                                                        <a href="{{ $link->link }}" class="text-purple" target="_blank">{{ $link->name }}</a>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-center">{{ $row->quantite }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            @endif
        @endforeach
    @endif

    <div class="footer">
        @include('_pdf.facture.facture_footer_pdf')
    </div>

</body>
</html>
