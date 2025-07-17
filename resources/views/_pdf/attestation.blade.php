<!DOCTYPE html>
<html lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/table.css">
    <link rel="stylesheet" href="css/pdf.css">
    <link rel="stylesheet" href="css/text.css">
    <title>Attestation</title>

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
            <td align='center' width="100%" class="border_white">
                <div class="logo" style="text-align: center; padding: 10px;">
                    <div>logo</div>
                </div>
            </td>
        </tr>
        <tr>
            <td align="right" class="border_white">
                <div class="doc_title" style="text-transform: uppercase">{{ $title }}</div>
            </td>
        </tr>
    </table>


    <div><i>{{ str_pad($carbon->day,2, '0', STR_PAD_LEFT) }} - {{ str_pad($carbon->month,2, '0', STR_PAD_LEFT) }} - {{ $carbon->year }}</i></div>
    <div class="doc_title" style="text-transform: uppercase">{{ $title }}</div>

    <div>
        Je soussigné, Monsieur Diène DIAGNE, Administrateur de l'entreprise <b>{{ env('APP_NAME') }}</b>,
        atteste que <b>{{ $team->firstname }} {{ $team->lastname }}</b> a effectué un stage pratique au sein de notre entreprise
        du <b>{{ $team->start_date ?? '18 juin 2025' }}</b> au <b>{{ $team->end_date ?? '16 juillet 2025' }}</b>.

        En foi de quoi, je délivre la présente attestation pour servir et valoir ce que de droit.
    </div>

    <div class="text-end" style="margin-top: 20px;">
        <div>Administrateur</div>
        <div>Diène DIAGNE</div>
    </div>


</body>
</html>
