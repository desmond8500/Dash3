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
    <title>Teletek SSI</title>
</head>

<body>
    @include('_pdf.fiches.fiche_header')

    @php $key = 1; @endphp

    <table class="table ">
        <tr>
            <td colspan="3" class="title4">Liste des zones</td>
        </tr>
        <tr class="subtitle4">
            <td width='10px'>Zone</td>
            <td>Equipement</td>
            <td>Nom </td>
            {{-- <td>Code</td> --}}
        </tr>
        @foreach ($zones as $zone)
            <tr>
                <td class="text-center">{{ $zone->number }}</td>
                <td>{{ $zone->equipement }}</td>
                <td>{{ $zone->name }}</td>
                {{-- <td>{{ $zone->code }}</td> --}}
            </tr>
        @endforeach
    </table>


    @php $key = 1; @endphp

    <table class="table mt-1">
        <tr>
            <td colspan="3" class="title1">En cas d'alarme</td>
        </tr>
        <tr>
            <td width="50px">
                <div class="number_a">{{ $key++ }}</div>
            </td>
            <td>N'entrez pas dans la salle si vous n'êtes pas une personne habilitée </td>
            <td>

            </td>
        </tr>
        <tr>
            <td>
                <div class="number_a">{{ $key++ }}</div>
            </td>
            <td>Vérifiez que la clé est présente et est sur <b class="text-danger">ON</b> </td>
            <td align="center">
                <img src="fiches/img/supra/cle.png" alt="" style="height: 100px">
            </td>
        </tr>
        <tr>
            <td>
                <div class="number_a">{{ $key++ }}</div>
            </td>
            <td>Si c'est une fausse alarme appuyez sur le bouton bleu pour bloquer le processus </td>
            <td>

            </td>
        </tr>
        <tr>
            <td>
                <div class="number_a">{{ $key++ }}</div>
            </td>
            <td>Appuyez sur le bouton <span class="text-danger fw-bold">Accès Clavier</span> pour activer le clavier
            </td>
            <td>
                <img src="fiches/img/supra/1.png" alt="">
            </td>
        </tr>
        <tr>
            <td>
                <div class="number_a">{{ $key++ }}</div>
            </td>
            <td>Appuyez sur le bouton <span class="text-danger fw-bold">Arret/Réact</span> pour arreter la sirène </td>
            <td>
                <img src="fiches/img/supra/2.png" alt="">
            </td>
        </tr>
        <tr>
            <td>
                <div class="number_a">{{ $key++ }}</div>
            </td>
            <td>Appuyez sur le bouton <span class="text-danger fw-bold">Arret ronfleur</span> pour arreter le bip de la
                centrale </td>
            <td>
                <img src="fiches/img/supra/5.png" alt="">
            </td>
        </tr>
        <tr>
            <td>
                <div class="number_a">{{ $key++ }}</div>
            </td>
            <td>Appuyez sur le bouton <span class="text-danger fw-bold">Réarm</span> pour réinitialiser la centrale
            </td>
            <td>
                <img src="fiches/img/supra/6.png" alt="">
            </td>
        </tr>
    </table>
    @php $key = 1; @endphp

    <table class="table mt-1">
        <tr>
            <td colspan="3" class="title2">En cas de dérangement</td>
        </tr>
        <tr>
            <td width="50px">
                <div class="number_a">{{ $key++ }}</div>
            </td>
            <td colspan="2">S'il y a un problème la centrale bippe par intermittence. Il faut prévenir le service de
                maintenance </td>
        </tr>
        <tr>
            <td>
                <div class="number_a">{{ $key++ }}</div>
            </td>
            <td>Appuyer sur le bouton <span>Arret ronfleur</span> pour arreter le bip de la centrale </td>
            <td width="50px">
                <img src="fiches/img/supra/5.png" alt="">
            </td>
        </tr>
    </table>

    @include('_pdf.fiches.fiche_footer')

</body>

</html>
