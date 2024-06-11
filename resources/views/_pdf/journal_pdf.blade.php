<!DOCTYPE html>
<html lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/table.css">
    <link rel="stylesheet" href="css/pdf.css">
    <link rel="stylesheet" href="css/text.css">
    <link rel="stylesheet" href="css/tasks.css">
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
            <td width="150px" class="border_white">
                <div class="logo">
                    <div>Logo</div>

                </div>
            </td>
            <td class="border_white" align="left">
                <div>{{ env('MAIN_NAME') }}</div>
            </td>
            <td align="right" class="border_white">
                <div class="doc_title" style="text-transform: uppercase">{{ $title }}</div>
                {{-- <div><b>{{ $commande->name }}</b></div> --}}
                <div><i>{{ str_pad($carbon->day,2, '0', STR_PAD_LEFT) }} - {{ str_pad($carbon->month,2, '0', STR_PAD_LEFT) }} - {{ $carbon->year }}</i></div>
            </td>
        </tr>
    </table>

    <div>
        @parsedown($journal->description)
    </div>

</body>
</html>
