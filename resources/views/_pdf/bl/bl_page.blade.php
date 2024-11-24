<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/table.css">
    <link rel="stylesheet" href="css/text.css">
    <link rel="stylesheet" href="css/margin.css">
    <link rel="stylesheet" href="css/bl.css">
    <title>Bordereau</title>
</head>

<body>
    @include('_pdf.bl.bl_header')

    @yield('content')

    @include('_pdf.bl.bl_sign')

</body>

</html>
