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

    <table class="table zone" >
        <tr>
            <td colspan="2" class="title4">Liste des zones</td>
        </tr>
        <tr>
            <td width="50%" style="font-size: 12px">
                <table width="100%">
                    <tr class="subtitle4" style="font-size: 12px">
                        <td width='10px'>Zone</td>
                        <td>Equipement</td>
                        <td>Nom </td>
                    </tr>
                    @foreach ($zones as $key => $zone)
                        @if($key < 8)
                        <tr style="font-size: 12px">
                            <td class="text-center">{{ $zone->number }}</td>
                            <td>{{ $zone->equipement }}</td>
                            <td>{{ $zone->name }}</td>
                        </tr>
                        @endif
                    @endforeach
                </table>
            </td>
            <td width="50%" style="font-size: 10px">
                @if (count($zones) > 8)
                    <table width="100%">

                        <tr class="subtitle4" style="font-size: 12px">
                            <td width='10px'>Zone</td>
                            <td>Equipement</td>
                            <td>Nom </td>
                        </tr>

                        @foreach ($zones as $key => $zone)
                            @if($key >= 8)
                                <tr>
                                    <td class="text-center">{{ $zone->number }}</td>
                                    <td>{{ $zone->equipement }}</td>
                                    <td>{{ $zone->name }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </table>
                @endif
            </td>
        </tr>

        {{-- <tr class="subtitle4">
            <td width='10px'>Zone</td>
            <td>Equipement</td>
            <td>Nom </td>
        </tr>
        @foreach ($zones as $zone)
            <tr>
                <td class="text-center">{{ $zone->number }}</td>
                <td>{{ $zone->equipement }}</td>
                <td>{{ $zone->name }}</td>
            </tr>
        @endforeach --}}
    </table>


    @php $key = 1; @endphp

    <table class="table mt-1 zone">
        <tr>
            <td colspan="3" class="title1">En cas d'alarme</td>
        </tr>
        <tr>
            <td width="50px">
                <div class="number_a">{{ $key++ }}</div>
            </td>
            <td colspan="2">
                <div>En cas d'alarme regardez la <b class="text-danger">zone</b> allumée en rouge pour identifier le local concerné.</div>
                <div>Vérifiez que la clé est en position 2 <b>(NIVEAU D'ACCES)</b></div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="number_a">{{ $key++ }}</div>
            </td>
            <td>Appuyez sur le bouton <b class="text-danger">ARRET EVACUATION</b> pour stopper les sirènes </td>
            <td align="center" width="50px">
                <img src="fiches/img/teletek/evac.png" alt="" style="height: 50px">
            </td>
        </tr>
        <tr>
            <td>
                <div class="number_a">{{ $key++ }}</div>
            </td>
            <td>Appuyez sur le bouton <b class="text-danger">ARRET SIGNAL SONORE</b> pour arrêter le bip de la centrale. </td>
            <td align="center" width="50px">
                <img src="fiches/img/teletek/signal.png" alt="" style="height: 50px">
            </td>
        </tr>
        <tr>
            <td>
                <div class="number_a">{{ $key++ }}</div>
            </td>
            <td>
                Allez à la zone concernée pour vérifier si l'alarme est réelle.
                Si tel est le cas utilisez un extincteur en cas de début d'incendie ou appellez les pompiers.
                Si c'est une fausse alarme, rearmez la centrale.
            </td>
            <td align="center" width="50px">
                <img src="fiches/img/teletek/signal.png" alt="" style="height: 50px">
            </td>
        </tr>
        <tr>
            <td>
                <div class="number_a">{{ $key++ }}</div>
            </td>
            <td>Après vérification appuyez sur <b class="text-danger">REARMEMENT</b> pour remmetre la centrale à zéro.
                Si c'est un déclencheur qui a été actionné, il faut le remettre en position normale avant de réarmer la centrale.
            </td>
            <td align="center" width="50px" >
                <img src="fiches/img/teletek/rearm.png" alt="" style="height: 50px">
            </td>
        </tr>

    </table>
    @php $key = 1; @endphp

    <table class="table mt-1 zone">
        <tr>
            <td colspan="3" class="title2">En cas de dérangement</td>
        </tr>
        <tr>
            <td>
                <div class="number_a">{{ $key++ }}</div>
            </td>
            <td>S'il y a une un dérangement la centrale émet des bips intermittents. Appuyez sur le bouton <span>Arret Signal Sonore</span> pour les stopper puis contactez le service de maintenance. </td>
            <td width="50px">
                <img src="fiches/img/teletek/signal.png" alt="" style="height: 50px">
            </td>
        </tr>
    </table>

    @include('_pdf.fiches.fiche_footer')

</body>

</html>
