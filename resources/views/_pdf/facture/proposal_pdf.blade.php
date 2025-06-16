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
                @if ($proposal->logo)
                    @if ($logo)
                        <div style="width: 80px; height: 80px;" >
                            <img src="{{ $logo }}" alt="logo" style="width:100%; height:100%;">
                        </div>
                    @endif
                @endif
            </td>
            <td width="300px" class="border_white fw-bold" align="left" style="{{ $title_css }}; color: #{{ $color1 }}" >
                <div>{{ env('MAIN_NAME') }}</div>
            </td>
            <td align="right" class="border_white">
                <div class="doc_title" style="text-transform: uppercase; color: #{{ $color1 }} ">{{ $title }}</div>

                <div>
                    <i class="text-muted"> {{ ($devis->formatDate()) }}</i>
                </div>

            </td>
        </tr>
    </table>


    <div class="">
        <table>
            <tr style="border: 1px solid gray" >
                <td class="border-white" width="350px">
                    @if ($proposal->client_name ==true)
                        <div>
                            <span class="fw-bold">Client : </span> <span>{{ $devis->client_name ?? $devis->projet->client->name }}</span>
                        </div>
                        @else
                    @endif
                    @if ($proposal->projet_name)
                        <div>
                            <span class="fw-bold">Projet : </span> <span>{{ $devis->projet->name }}</span>
                        </div>
                    @endif

                </td>
                <td class="border-white">
                    @if ($proposal->description)
                        <div class="fw-bold">Description</div>
                        <div>{!! nl2br($devis->description) !!}</div>
                    @endif
                </td>
            </tr>
        </table>

    </div>



    @if ($devis->sections)
        @foreach ($devis->sections as $key => $section)

            @if ($section->status)
                <div class="my-1" style="border: 1px solid #219c90">
                </div>

                <table class="table ">
                    <tr>
                        <td colspan="3">
                            <div class="fw-bold">{{ $section->section }}</div>
                            <div class="text-muted  " style="font-size: 12px;"> {!! $section->proposition !!} </div>
                        </td>
                    </tr>
                    <thead>
                        <tr style="background-color: #{{ $color2 }}; color: #fff;">
                            <th scope="col" style="width: 150px;">Photo</th>
                            <th scope="col" class="text-center">Description</th>
                            <th scope="col" style="width: 10px" class="text-center">Quantité</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($section->rows->sortBy('priorite_id') as $row)
                            @if ($row->priorite_id<5   )
                                <tr >
                                    <td class="text-center" style="vertical-align: top;">
                                        @isset ($row->article->image)
                                            <img src="{{ ($row->article->image) }}" style="height: 150px" alt="I" class="avatar avatar-sm me-2">
                                        @else
                                            <img src="{{ ("img/icons/packaging.png") }}" style="height: 150px" alt="I" class="avatar avatar-sm me-2 bg-white border border-white">
                                        @endisset
                                    </td>
                                    <td style="vertical-align: top;">
                                        <div class="mb-1">
                                            @if ($row->article_id)
                                                <a href="{{ route('article',['article_id'=>$row->article_id]) }}" style="color: #219c99; text-decoration: none;" target="_blank">
                                                    {{ $row->designation }}
                                                </a>
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
            <div class="page-break"></div>
        @endforeach
    @endif


    @if ($proposal->footer)
    <div class="footer">
        @include('_pdf.facture.facture_footer_pdf')
    </div>
    @endif

</body>
</html>
