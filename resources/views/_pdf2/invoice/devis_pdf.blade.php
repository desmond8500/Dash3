{{--
    Devis / facture au format PDF, rendu par spatie/laravel-pdf (Browsershot).
    Reprend la présentation du modèle dompdf (_pdf.facture.facture_pdf) :
    en-tête, client et projet, sections avec sous-totaux, totaux, modalités,
    puis les détails techniques des sections concernées.
--}}
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ ucfirst($title) }} {{ strtoupper($devis->reference) }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <style>
        @page { size: A4; }
        body { font-family: "Helvetica Neue", Arial, sans-serif; font-size: 12px; color: #1d273b; }
        .sheet { padding: 0 14mm; }
        .doc-title { font-size: 22px; font-weight: 700; text-transform: uppercase; line-height: 1.1; }
        .brand { font-size: 18px; font-weight: 700; }
        .head { border-bottom: 2px solid {{ $color1 }}; padding-bottom: 6px; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; }
        .infos td { border: 1px solid #adb5bd; padding: 6px 8px; vertical-align: top; }
        .rows th, .rows td { border: 1px solid #dee2e6; padding: 4px 6px; }
        .rows thead th { background: {{ $color1 }}; color: #fff; font-weight: 600; }
        .rows .section-row th { background: {{ $color2 }}; color: #1d273b; font-size: 13px; }
        .rows .subtotal td { background: #f1f3f5; font-weight: 600; }
        .totals td { padding: 4px 8px; border: 1px solid #dee2e6; }
        .totals .label { background: #e9ecef; font-weight: 600; }
        .totals .ttc { background: {{ $color2 }}; font-weight: 700; font-size: 13px; }
        .muted { color: #6c757d; }
        .nowrap { white-space: nowrap; }
        .pre { white-space: pre-line; }
        .zero { color: #d63939; }
        /* Les lignes et les blocs ne sont jamais coupés entre deux pages */
        tr, .avoid-break { page-break-inside: avoid; }
        thead { display: table-header-group; }
        .page-break { page-break-before: always; }
        .tech-title { color: #219c90; font-size: 18px; font-weight: 700; text-transform: uppercase; }
        .tech th { background: #219c90; color: #fff; }
        .tech img { max-height: 90px; max-width: 130px; object-fit: contain; }
        .signs img { height: 70px; margin-right: 6px; }
    </style>
</head>

<body>
    <div class="sheet">
        @php
            $logoPath = public_path('img/tyto/logo.png');
            $signPath = public_path('img/tyto/signature.jpg');
            $stampPath = public_path('img/tyto/tampon.jpg');
            $quantitatif = $title === 'quantitatif';
            $colspan = $quantitatif ? 2 : 4;
            $total_marge = 0;
        @endphp

        {{-- En-tête --}}
        <table class="head">
            <tr>
                <td style="width: 90px;">
                    @if (file_exists($logoPath))
                        <img src="{{ $logoPath }}" alt="" style="width: 80px;">
                    @endif
                </td>
                <td class="brand" style="color: {{ $color1 }};">{{ env('MAIN_NAME', config('app.name')) }}</td>
                <td style="text-align: right;">
                    <div class="doc-title" style="color: {{ $color1 }};">{{ $title }}</div>
                    @unless ($quantitatif)
                        <div><i>#{{ strtoupper($devis->reference) }}</i></div>
                    @endunless
                    <div class="muted"><i>Emis le : {{ $devis->formatDate($devis->emitdate) ?? $devis->formatDate() }}</i></div>
                    @if ($devis->facture_date && $title === 'facture')
                        <div class="muted"><i>Facturé le : {{ $devis->formatDate($devis->facture_date) }}</i></div>
                    @endif
                    @if ($devis->paydate && $title === 'facture')
                        <div class="muted"><i>Payé le : {{ $devis->formatDate($devis->paydate) }}</i></div>
                    @endif
                </td>
            </tr>
        </table>

        {{-- Client, projet, description --}}
        <table class="infos">
            <tr>
                <td style="width: 45%;">
                    <div><span class="fw-bold">Client : </span>{{ $devis->client_name ?? $devis->projet->client->name }}</div>
                    <div><span class="fw-bold">Projet : </span>{{ $devis->projet->name }}</div>
                </td>
                <td>
                    <div class="fw-bold">Description</div>
                    <div class="pre">{{ $devis->description }}</div>
                </td>
            </tr>
        </table>

        {{-- Lignes du devis, par section --}}
        <table class="rows mt-2">
            <thead>
                <tr>
                    <th class="text-start">Désignation</th>
                    <th style="width: 70px;" class="text-center">Quantité</th>
                    @unless ($quantitatif)
                        <th style="width: 85px;" class="text-center">Prix</th>
                        <th style="width: 105px;" class="text-center">Total</th>
                    @endunless
                </tr>
            </thead>
            @foreach ($sections->sortBy('ordre') as $section)
                @continue(! $section->rows->count())
                @php $subtotal = 0; @endphp
                <tr class="section-row">
                    <th colspan="{{ $colspan }}">{{ $section->section }}</th>
                </tr>
                <tbody>
                    @foreach ($section->rows->sortBy('priorite_id') as $row)
                        @php
                            $ligne = $row->quantite * $row->coef * $row->prix;
                            $total_marge += $ligne;
                            $subtotal += $ligne;
                        @endphp
                        <tr @class(['zero' => $row->quantite == 0 || $row->prix == 0])>
                            <td>
                                <div class="fw-bold pre">{{ $row->designation }}</div>
                                <div class="muted pre" style="font-size: 10px;">{{ $row->reference }}</div>
                            </td>
                            <td class="text-center">{{ $row->quantite }}</td>
                            @unless ($quantitatif)
                                <td class="text-center nowrap">{{ number_format($row->prix * $row->coef, 0, '.', ' ') }}</td>
                                <td class="text-center nowrap">{{ number_format($ligne, 0, '.', ' ') }}</td>
                            @endunless
                        </tr>
                    @endforeach
                    @unless ($quantitatif)
                        <tr class="subtotal">
                            <td colspan="3">Sous Total</td>
                            <td class="text-end nowrap">{{ number_format($subtotal, 0, '.', ' ') }} F</td>
                        </tr>
                    @endunless
                </tbody>
            @endforeach
        </table>

        {{-- Totaux, signature et tampon --}}
        @unless ($quantitatif)
            @php
                $tva = $devis->tax === 'tva' ? $total_marge * 0.18 : 0;
                $brs = $devis->tax === 'brs' ? $total_marge * 0.05 : 0;
                $remise = $total_marge * ($devis->remise ?? 0);
                $ttc = $total_marge + $tva - $brs - $remise;
            @endphp
            <table class="mt-3 avoid-break">
                <tr>
                    <td class="signs text-center" style="width: 55%;">
                        @if (file_exists($signPath))<img src="{{ $signPath }}" alt="">@endif
                        @if (file_exists($stampPath))<img src="{{ $stampPath }}" alt="">@endif
                    </td>
                    <td>
                        <table class="totals">
                            <tr>
                                <td class="label">TOTAL HT</td>
                                <td class="text-end nowrap">{{ number_format($total_marge, 0, '.', ' ') }} F CFA</td>
                            </tr>
                            @if ($devis->tax === 'tva')
                                <tr>
                                    <td class="label">TVA</td>
                                    <td class="text-end nowrap">{{ number_format($tva, 0, '.', ' ') }} F CFA</td>
                                </tr>
                            @elseif ($devis->tax === 'brs')
                                <tr>
                                    <td class="label">BRS</td>
                                    <td class="text-end nowrap">- {{ number_format($brs, 0, '.', ' ') }} F CFA</td>
                                </tr>
                            @else
                                <tr>
                                    <td class="label">TVA</td>
                                    <td class="text-end nowrap">0 F CFA</td>
                                </tr>
                            @endif
                            @if (($devis->remise ?? 0) > 0)
                                <tr>
                                    <td class="label">Remise {{ $devis->remise * 100 }}%</td>
                                    <td class="text-end nowrap">- {{ number_format($remise, 0, '.', ' ') }} F CFA</td>
                                </tr>
                            @endif
                            <tr>
                                <td class="ttc">TOTAL TTC</td>
                                <td class="ttc text-end nowrap">{{ number_format($ttc, 0, '.', ' ') }} F CFA</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        @endunless

        {{-- Modalités et notes --}}
        @if (($devis->modalite || $devis->note) && $title === 'devis')
            <table class="mt-3 avoid-break">
                <tr>
                    @if ($devis->modalite)
                        <td style="vertical-align: top; width: 50%; padding-right: 10px;">
                            <div class="fw-bold text-decoration-underline mb-1">Modalités :</div>
                            <div class="pre">{{ $devis->modalite }}</div>
                        </td>
                    @endif
                    @if ($devis->note)
                        <td style="vertical-align: top;">
                            <div class="fw-bold text-decoration-underline mb-1">Notes :</div>
                            <div class="pre">{{ $devis->note }}</div>
                        </td>
                    @endif
                </tr>
            </table>
        @endif

        {{-- Détails techniques des sections qui en ont --}}
        @php $techniques = $sections->filter(fn ($s) => $s->status && $s->rows->where('priorite_id', '<', 5)->count()); @endphp
        @if ($techniques->count())
            <div class="page-break"></div>
            <div class="tech-title">Détails Techniques</div>
            <div style="border-bottom: 2px solid #219c90; margin-bottom: 10px;"></div>

            @foreach ($techniques as $section)
                <table class="rows tech mt-2">
                    <tr>
                        <td colspan="3">
                            <div class="fw-bold">{{ $section->section }}</div>
                            <div class="pre" style="font-size: 11px;">{{ $section->proposition }}</div>
                        </td>
                    </tr>
                    <thead>
                        <tr>
                            <th style="width: 140px;">Photo</th>
                            <th class="text-center">Description</th>
                            <th style="width: 50px;" class="text-center">Qte</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($section->rows->sortBy('priorite_id') as $row)
                            @continue($row->priorite_id >= 5)
                            @php
                                $img = $row->article?->image ? public_path($row->article->image) : public_path('img/icons/packaging.png');
                                $fiche = $row->article?->links?->firstWhere('name', 'Fiche Technique');
                            @endphp
                            <tr>
                                <td class="text-center">
                                    @if (file_exists($img))<img src="{{ $img }}" alt="">@endif
                                </td>
                                <td style="vertical-align: top;">
                                    <div class="d-flex justify-content-between">
                                        <span>{{ $row->designation }}</span>
                                        @if ($fiche)
                                            <a href="{{ $fiche->link }}" style="color: #ae3ec9; font-size: 11px;">Fiche</a>
                                        @endif
                                    </div>
                                    <div class="muted pre" style="font-size: 11px; border-bottom: 1px solid #dee2e6; padding-bottom: 4px;">{{ $row->reference }}</div>
                                    <div class="pre" style="font-size: 11px;">{{ $row->article->description ?? '' }}</div>
                                    <div class="pre" style="font-size: 11px;">{{ $row->comment ?? '' }}</div>
                                </td>
                                <td class="text-center">{{ $row->quantite }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endforeach
        @endif
    </div>
</body>

</html>
