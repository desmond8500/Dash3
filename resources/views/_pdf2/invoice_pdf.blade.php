<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/css/tabler.min.css" />

    <title>Tabler demo</title>
</head>

<body class="container">
    @livewire('pdf.invoice.invoice_header_pdf', ['invoice_id' => $invoice->id, 'title' => $title], key($invoice->id))

    <div class="border rounded p-2 mt-2">
        <div class="row">
            <div class="col-auto">
                <div class=" fw-bold text-uppercase"> {{ $invoice->projet->client->name }}</div>
                <div class="fw-bold">{{ $invoice->projet->name }}</div>
            </div>
            <div class="col">
                <div>{{ $invoice->projet->description }}</div>
            </div>
        </div>
    </div>

    @livewire('pdf.invoice.invoice_table_pdf', ['invoice_id' => $invoice->id, 'title' => $title], key($invoice->id))

</body>

</html>
