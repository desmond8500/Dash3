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
                <i>{{ $journal->formatDate() }}</i>
            </td>
        </tr>
    </table>

    <hr>
    <div>
        <span class="fw-bold">Projet : </span> <span>{{ $journal->projet->name }}</span>
    </div>

    <div class="journal_title" style="color: #{{ $color1 }}">
        {{ $journal->title }}
    </div>

    <div>
        @parsedown($journal->description)
    </div>

</body>
</html>
