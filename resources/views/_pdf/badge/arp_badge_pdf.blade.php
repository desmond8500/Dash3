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
    </style>

    <div>
        <table class="table">
            <tr style="padding: 0px; height: 50px">
                <td  style="padding: 0px; ">
                    <img src="{{ $flag }}"  width="80px" alt="" class="flag" >
                </td>
                <td  class="logo" style="padding: 0px;">
                    <img src="{{ $logo }}"  width="150px" alt="" class="logo" style="margin-right: 10px">
                </td>
            </tr>
            <tr>
                <td rowspan="3" height="130px">
                    <div class="photo">
                        <img src="{{ $photo }}" width="100%">
                    </div>
                </td>
                <td>
                    <div>{{ $prenom }} {{ $nom }}</div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="fonction">{{ $fonction }}</div>
                </td>
            </tr>
            <tr>
                <td >
                    <div class="direction">{{ $direction }}</div>
                </td>
            </tr>
        </table>

    </div>


</body>

</html>
