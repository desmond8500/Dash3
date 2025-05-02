<!DOCTYPE html>
<html lang="fr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/table.css">
    <link rel="stylesheet" href="css/text.css">
    <link rel="stylesheet" href="css/margin.css">
    <link rel="stylesheet" href="css/fiche1.css">
    <title>Fiche de présence</title>
</head>

<body>
    @include('_pdf.fiches.fiche_header')



    <table class="table">
        <thead class="thead">
            <tr>
                <td align="center" width="20px">#</td>
                <td>Désignation</td>
                <td align="center" width="30px">Référence</td>
                <td align="center" width="30px">Quantité</td>
                <td align="center" width="120px">Commentaires</td>
            </tr>
        </thead>
        <tbody>

            @for ($i = 1; $i<16; $i++) <tr>
                <td align="center" height="3rem">{{ $i }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                </tr>
                @endfor
        </tbody>
    </table>



</body>

</html>
