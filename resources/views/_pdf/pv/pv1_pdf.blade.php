<!DOCTYPE html>
<html lang="fr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/doe.css">
    <link rel="stylesheet" href="css/table.css">
    <link rel="stylesheet" href="css/text.css">
    <link rel="stylesheet" href="css/margin.css">
    <link rel="stylesheet" href="css/pdf.css">
    <title>Procès verbal</title>

</head>

<body>
    <table class="table mb-4 mt-5">
        <tr>
            <td class="text-center p-3">
                <div class="fs-4 fw-bold text-uppercase">Maitre d'ouvrage</div>
                <div class="fs-4">BRT</div>
                <div class="fs-5">Adresse</div>
            </td>
            <td class="text-center p-3">
                <div class="fs-4 fw-bold text-uppercase">Maitre d'oeuvre</div>
                <div class="fs-4">BCS</div>
                <div class="fs-5">Adresse</div>
            </td>
        </tr>
    </table>

    <table class="table mb-4">
        <tr>
            <td class="text-center py-4">
                <div class="logo">
                </div>
                <div class="fs-2 fw-bold text-uppercase">Projet</div>
                <div class="fs-5">Description du projet</div>
            </td>
        </tr>
    </table>

    <table class="table mb-4">
        <tr>
            <td class="fs-2 text-uppercase text-center py-4">
                <div class="">Dossier d'ouvrage exécuté</div>
                <div class="">(DOE)</div>
            </td>
        </tr>
    </table>


    <table class="table mb-2">
        <thead class="bg-gray-600 text-white fs-5">
            <tr class="text-center">
                <td width="10px">Date</td>
                <td>Réalisé par</td>
                <td>Approuvé par</td>
                <td>Observations</td>
            </tr>
        </thead>
        <tr>
            <td>03/08/2024</td>
            <td class="text-center">Diène Diagne</td>
            <td class="text-center">Diène Diagne</td>
            <td>Good</td>
        </tr>
    </table>



    <div class="page-break"></div>

    <h2>Présentation du projet</h2>
    <div>

    </div>

    <h2>Liste des équipements</h2>
    <div>
        <table class="table mb-2">
            <tr>
                <td colspan="4" class="text-center fw-bold bg-black text-white">SYSTEME</td>
            </tr>
            <thead>
                <tr>
                    <td width="10px" class="text-center">#</td>
                    <td>Désignation</td>
                    <td>Référence</td>
                    <td width="10px">Quantité</td>
                </tr>
            </thead>
            {{-- @foreach ($collection as $key => $item) --}}
            <tr>
                <td class="text-center">00</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            {{-- @endforeach --}}
        </table>


    </div>
    <div class="page-break"></div>

    <h2>Plan de zonage</h2>

    <div class="page-break"></div>

    <h2>Schéma synoptique</h2>

    <h2>Plan de recollement</h2>

    <h2>Maintenance</h2>

    <h2>Fiches et manuels</h2>



</body>

</html>
