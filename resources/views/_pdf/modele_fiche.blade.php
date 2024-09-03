<!DOCTYPE html>
<html lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/table.css">
    <link rel="stylesheet" href="css/pdf.css">
    <link rel="stylesheet" href="css/text.css">
    <title>{{ $name }}</title>

</head>
<body>
    <table class="table" style="margin-bottom: 10px;">
        <tr>
            <td  class="border_white">
                <div class="logo">
                    <img src="{{ env('LOGO') }}" alt="" class="logo">

                </div>
                <td class="border-white">
                    <div class="doc_title ">
                        {{ $title }}
                    </div>
                </td>
            </td>
            <td align="right" class="border_white">
                <div class="doc_title" style="text-transform: ">{{ $name }}</div>
                <div >
                    <div class="fw-bold text-left" style="margin-top: 10px">Site: </div>
                    <div class="fw-bold text-left" style="margin-top: 10px">Page: </div>
                </div>

            </td>
        </tr>
    </table>

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

            @for ($i = 1; $i<16; $i++)
            <tr>
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
