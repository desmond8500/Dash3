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
    <title>Supra</title>

</head>

<body>

    <div class="header">
        <div class="page_title">Fiche D'exploitation</div>

        <div>
            <table class="table">
                <tr>
                    <td width="10px"  align="right" class="border-white">
                        <img src="{{ $logo }}" alt="" class="logo">
                    </td>
                    <td class="border-white">
                        <div class="structure_title">
                            {{ $title }}
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    @php $key = 1; @endphp

    <table class="table ">
        <tr>
            <td colspan="3" class="title1">En cas d'alarme</td>
        </tr>
        <tr>
            <td width="50px"> <div class="number_a">{{ $key++ }}</div> </td>
            <td>N'entrez pas dans la salle si vous n'êtes pas une personne habilitée </td>
            <td>

            </td>
        </tr>
        <tr>
            <td> <div class="number_a">{{ $key++ }}</div> </td>
            <td>Vérifiez que la clé est présente et est sur <b class="text-danger">ON</b> </td>
            <td align="center">
                <img src="fiches/img/supra/cle.png" alt="" style="height: 100px">
            </td>
        </tr>
        <tr>
            <td> <div class="number_a">{{ $key++ }}</div> </td>
            <td>Si c'est une fausse alarme appuyez sur le bouton bleu pour bloquer le processus  </td>
            <td>

            </td>
        </tr>
        <tr>
            <td> <div class="number_a">{{ $key++ }}</div> </td>
            <td>Appuyez sur le bouton <span class="text-danger fw-bold">Accès Clavier</span> pour activer le clavier  </td>
            <td>
                <img src="fiches/img/supra/1.png" alt="">
            </td>
        </tr>
        <tr>
            <td> <div class="number_a">{{ $key++ }}</div> </td>
            <td>Appuyez sur le bouton <span class="text-danger fw-bold">Arret/Réact</span> pour arreter la sirène  </td>
            <td>
                <img src="fiches/img/supra/2.png" alt="">
            </td>
        </tr>
        <tr>
            <td> <div class="number_a">{{ $key++ }}</div> </td>
            <td>Appuyez sur le bouton <span class="text-danger fw-bold">Arret ronfleur</span> pour arreter le bip de la centrale  </td>
            <td>
                <img src="fiches/img/supra/5.png" alt="">
            </td>
        </tr>
        <tr>
            <td> <div class="number_a">{{ $key++ }}</div> </td>
            <td>Appuyez sur le bouton <span class="text-danger fw-bold">Réarm</span> pour réinitialiser la centrale  </td>
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
            <td width="50px"><div class="number_a">{{ $key++ }}</div></td>
            <td colspan="2">S'il y a un problème la centrale bippe par intermittence. Il faut prévenir le service de maintenance </td>
        </tr>
        <tr>
            <td><div class="number_a">{{ $key++ }}</div></td>
            <td>Appuyer sur le bouton <span>Arret ronfleur</span> pour arreter le bip de la centrale  </td>
            <td width="50px">
                <img src="fiches/img/supra/5.png" alt="">
            </td>
        </tr>
    </table>

    <table class="table mt-1">
        <tr>
            <td colspan="2" class="title3">CONTACT DE LA MAINTENANCE</td>
        </tr>
        <tr>
            <td width="10px" style="border-right-color: white">
                <div class="number_b" >
                    <img src="fiches/img/phone.png" alt="">
                </div>
            </td>
            <td>
                <div class="fw-bold fs-5 text-center mb-1">En cas de dérangement Prévenez le service de Maintenance</div>
                @if ($phone)
                    <div class="contact phone"> <i class="ti ti-user"></i> {{ $phone }}</div>
                @endif
                @if ($email)
                    <div class="contact email">{{ $email }}</div>
                @endif
            </td>
        </tr>

    </table>

    <div class="client">
        {{ $client }}
    </div>


</body>

</html>
