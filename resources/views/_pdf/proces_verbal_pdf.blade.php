<!DOCTYPE html>
<html lang="fr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/pv.css">
    <link rel="stylesheet" href="css/table.css">
    <link rel="stylesheet" href="css/text.css">
    <link rel="stylesheet" href="css/margin.css">
    <title>Proces verbal</title>

</head>

<body>

    <div class="title">
        <h1>PROCÈS VERBAL DE RÉCEPTION DE TRAVAUX</h1>
    </div>

    <table class="table client">
        <tr class="">
            <td><b>CLIENT :</b> {{ $client }} </td>
            <td width="200px">Date:{{ $date }}</td>
        </tr>
    </table>

    <table class="table">

        <tr>
            <td>
                <h2>Societé</h2>
                <ul>
                    @foreach ($societes as $societe)
                        <li>{{ $societe }}</li>
                    @endforeach
                </ul>

            </td>
            <td>
                <h2>Systèmes</h2>
                <ul>
                    @foreach ($systemes as $systeme)
                        <li>{{ $systeme }}</li>
                    @endforeach
                </ul>
            </td>
        </tr>
    </table>



    <h2 class="mt-3 mb-1">Objet des travaux</h2>
    <div>
        qsdfsdfsdf
    </div>


    <h2 class="mt-3 mb-1">Liste du matériel</h2>

    <table class="table">
        <thead>
            <tr>
                <td>Désignation</td>
                <td width="100px" class="text-center">Réference</td>
                <td width='10px'>Quantité</td>
                <td>Observations</td>
            </tr>
        </thead>
        @foreach ($articles as $article)
            <tr>
                <td>{{ $article->designation }}</td>
                <td class="text-center">{{ $article->reference }}</td>
                <td class="text-center">{{ $article->quantite }}</td>
                <td></td>
            </tr>
        @endforeach
    </table>

    <h2 class="mt-3 mb-1">Liste des personnes présentes</h2>

    <table class="table ">
        <thead>
            <tr>
                <td>Prénom</td>
                <td>Nom</td>
                <td>Société</td>
                <td>Signature</td>
            </tr>
        </thead>
        @foreach ($personnes as $personne)
            <tr>
                <td>{{ $personne->prenom }}</td>
                <td>{{ $personne->nom }}</td>
                <td>{{ $personne->societe }}</td>
                <td></td>
            </tr>
        @endforeach
    </table>


    <h2 class="mt-3">Observations</h2>


</body>

</html>
