<!DOCTYPE html>
<html lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/table.css">
    <link rel="stylesheet" href="css/pdf.css">
    <link rel="stylesheet" href="css/text.css">
    <link rel="stylesheet" href="css/margin.css">
    <link rel="stylesheet" href="css/facture_pdf.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.5.1/dist/css/tabler.min.css" />
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css"> --}}
    <title>{{ ucfirst($type) }}</title>
</head>
<body>
    @livewire('erp/invoice/pdf/header',
    ['data' => [
        'logo'=> $logo,
        'proposal' => $proposal,
        'date' => $date,
    ]])
    @livewire('erp/invoice/pdf/resume', ['data' => ''])
    @livewire('erp/invoice/pdf/devis', [ 'quotation' => $quotation, ])
    {{-- @livewire('erp/invoice/pdf/details_tech', [ 'quotation' => $quotation, ]) --}}
    {{-- @livewire('erp/invoice/pdf/avancement', ['data' => [
        'quotation' => $quotation,
    ]]) --}}
    {{-- @livewire('erp/invoice/pdf/photos', ['data' => [
        'quotation' => $quotation,
    ]]) --}}
    {{-- @livewire('erp/invoice/pdf/taches', ['data' => [
        'quotation' => $quotation,
    ]]) --}}
    {{-- @livewire('erp/invoice/pdf/plans', ['data' => [
        'quotation' => $quotation,
    ]]) --}}

</body>
</html>
