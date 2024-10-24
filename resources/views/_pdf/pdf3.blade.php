<!DOCTYPE html>
<html lang="fr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/text.css">
    <link rel="stylesheet" href="css/badge/scd.css">
    <title>PDF 3</title>

</head>

<body>
    <style>
        @page {
            size: 5.5cm 8.6cm landscape;
            margin: 0px;
            background: #f2f5f4;
        }
        body{
            margin: 0px;
            font-family: Arial, Helvetica, sans-serif;
            }
        .page-break {
            page-break-after: always;
        }
    </style>

    <div>
        @foreach ($cards->sortby('nom') as $card)
            <table class="table">
                <tr>
                    <td>
                        <div style="padding-left: 5px">
                            <div style="padding-bottom: 10px;">{{ $card->prenom }}</div>
                            <div style="padding-bottom: 25px;">{{ strtoupper($card->nom )}}</div>
                            <div style="padding-bottom: 5px;">Entreprise:</div>
                            <div class="fw-bold">{{ $card->service }}</div>
                        </div>
                    </td>
                    <td align="right">
                        <img src="img/badges/bcs/scd2.png" alt="" height="205px">
                    </td>
                </tr>
            </table>

           <div class="page-break"></div>

        @endforeach


    </div>


</body>

</html>
