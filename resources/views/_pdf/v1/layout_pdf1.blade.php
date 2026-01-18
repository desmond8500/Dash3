{{-- <!DOCTYPE html>
<html lang="fr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/table.css">
    <link rel="stylesheet" href="css/text.css">
    <title>{{ $page_title }}</title>

</head>

<style>
    body {
        font-family: 'Roboto';
    }
</style>

<body>

    @foreach ($page_sections as $page_section)
        @include('_pdf.'.$page_section)
    @endforeach

</body>

</html> --}}


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Devis {{ $devis->reference ?? "REFERENCE" }}</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #000;
        }

        .clear {
            clear: both;
        }

    </style>
</head>

<body>

    @foreach ($page_sections as $page_section)
    @include('_pdf.'.$page_section)
    @endforeach

</body>

</html>
