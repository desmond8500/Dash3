<!DOCTYPE html>
<html lang="fr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/text.css">
    <link rel="stylesheet" href="css/badge/arp2.css">
    <title>PDF Test</title>

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
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
        }
        .page-break {
            page-break-after: always;
        }
    </style>

    <div>
        @foreach ($cards as $card)
            {{-- <table >
                <tr style="padding: 0px;">
                    <td  style="padding: 0px;">
                        <img src="{{ $flag }}"  width="80px" alt="" class="flag" style="position: absolute;">
                    </td>
                    <td  class="logo" style="padding: 0px;">
                        <img src="{{ $logo }}"  width="150px" alt="" class="logo" style="margin-right: 10px">
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="photo">
                            <img src="{{ $card->photo }}" width="100px" alt="" style="border-radius: 15px;">
                        </div>
                    </td>
                    <td>
                        <div class="nom ">
                            {{ $card->prenom }} {{ $card->nom }}
                        </div>
                        <div class="fonction">{{ $card->fonction }}</div>
                        <div class="service" >{{ $card->service }}</div>
                        <div class="direction" >{{ $card->direction }}</div>
                    </td>
                </tr>
            </table> --}}

            <table class="table">
                <tr style="padding: 0px; height: 50px">
                    <td style="padding: 0px; ">
                        <img src="{{ $flag }}" width="80px" alt="" class="flag">
                    </td>
                    <td class="logo" style="padding: 0px;">
                        <img src="{{ $logo }}" width="150px" alt="" class="logo" >
                    </td>
                </tr>
                <tr style="vertical-align: bottom;">
                    <td rowspan="3" height="140px" width="130px">
                        <div class="photo">
                            <div class="img">

                                <img src="{{ $card->photo }}" class="avatar">
                            </div>
                        </div>
                    </td>
                    <td style="vertical-align: bottom;">
                        <div class="nom">{{ $card->prenom }} {{ $card->nom }}</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="fonction">{{ $card->fonction }}</div>
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: top;">
                        <div class="direction">{{ $card->direction }}</div>
                    </td>
                </tr>
            </table>

           <div class="page-break"></div>

        @endforeach


    </div>


</body>

</html>
