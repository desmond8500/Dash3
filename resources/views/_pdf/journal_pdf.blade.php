{{--
    Rapport de travaux (journal), rendu par dompdf.
    Mise en page autonome : tout le style est dans ce fichier, sans CSS externe.
    Contrainte dompdf : ni flex ni grid, les colonnes passent par des tableaux.
--}}
@php
    $accent = '#' . ltrim(env('COLOR1', '0054a6'), '#');
    $accentSoft = '#' . ltrim(env('COLOR2', 'e8eef7'), '#');
    $logoEnv = env('LOGO');
    $logo = collect([$logoEnv, 'img/tyto/logo.png'])
        ->filter()
        ->map(fn ($chemin) => public_path($chemin))
        ->first(fn ($chemin) => is_file($chemin));
    $carbon->locale('fr_FR');
    $societe = env('MAIN_NAME', config('app.name'));
@endphp
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ $journal->title }}</title>
    <style>
        @page {
            margin: 92px 34px 58px 34px;
        }

        body {
            font-family: "DejaVu Sans", sans-serif;
            font-size: 11.5px;
            line-height: 1.45;
            color: #1f2a37;
            margin: 0;
        }

        /* ---------- Bandeau et pied, répétés sur chaque page ---------- */
        /* Bandeau clair dans l'esprit de l'ancien en-tête : logo à gauche,
           société au centre, type de rapport et date à droite, filet de couleur. */
        .band {
            position: fixed;
            top: -74px;
            left: 0;
            right: 0;
            height: 58px;
            border-bottom: 2px solid {{ $accent }};
        }

        .band td {
            vertical-align: middle;
            padding: 0 4px 6px 4px;
        }

        .band .societe {
            font-size: 15px;
            font-weight: bold;
            color: {{ $accent }};
            letter-spacing: 0.3px;
        }

        .band .baseline {
            font-size: 8.5px;
            color: #98a2b3;
        }

        .band .doc {
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: {{ $accent }};
        }

        .band .date {
            font-size: 10px;
            color: #667085;
        }

        .band .logo-box {
            width: 50px;
            height: 50px;
            border: 1px solid #eaecf0;
            border-radius: 6px;
            text-align: center;
        }

        .foot {
            position: fixed;
            bottom: -42px;
            left: 0;
            right: 0;
            height: 30px;
            border-top: 1px solid #e4e7ec;
            color: #98a2b3;
            font-size: 9px;
            padding-top: 5px;
        }

        .foot .page:after {
            content: counter(page);
        }

        /* ---------- Blocs ---------- */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        .plain td,
        .plain th {
            border: 0;
        }

        .card {
            background: #f9fafb;
            border: 1px solid #eaecf0;
            border-radius: 6px;
            padding: 9px 11px;
        }

        .card .label {
            font-size: 8.5px;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: #98a2b3;
        }

        .card .value {
            font-size: 12px;
            font-weight: bold;
            color: #1f2a37;
        }

        h1.journal {
            font-size: 21px;
            margin: 16px 0 2px 0;
            color: #101828;
        }

        .journal-meta {
            color: #667085;
            font-size: 10px;
            margin-bottom: 10px;
        }

        /* Titres de parties */
        .part {
            margin: 18px 0 8px 0;
            padding: 5px 0 5px 10px;
            border-left: 4px solid {{ $accent }};
            background: {{ $accentSoft }};
            border-radius: 0 4px 4px 0;
            font-size: 13px;
            font-weight: bold;
            color: {{ $accent }};
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .section-title {
            font-size: 13.5px;
            font-weight: bold;
            color: #101828;
            margin: 14px 0 4px 0;
            padding-bottom: 3px;
            border-bottom: 1px solid #eaecf0;
        }

        .section-num {
            display: inline-block;
            width: 18px;
            height: 18px;
            background: {{ $accent }};
            color: #ffffff;
            border-radius: 9px;
            text-align: center;
            font-size: 10px;
            margin-right: 5px;
        }

        /* Pastilles */
        .pill {
            display: inline-block;
            padding: 1px 8px;
            border-radius: 9px;
            font-size: 9.5px;
            background: #f2f4f7;
            color: #475467;
        }

        .pill-accent {
            background: {{ $accentSoft }};
            color: {{ $accent }};
        }

        .pill-done {
            background: #e7f6ec;
            color: #137547;
        }

        .pill-wait {
            background: #fff4e5;
            color: #b54708;
        }

        /* Tableaux de données */
        .data th {
            background: #f2f4f7;
            color: #344054;
            font-size: 9.5px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            text-align: left;
            padding: 6px 8px;
            border-bottom: 1px solid #eaecf0;
        }

        .data td {
            padding: 6px 8px;
            border-bottom: 1px solid #f2f4f7;
            vertical-align: top;
        }

        .data tr.alt td {
            background: #fcfcfd;
        }

        .data .group th {
            background: {{ $accentSoft }};
            color: {{ $accent }};
            text-transform: none;
            font-size: 11px;
        }

        .data .total td {
            background: #f9fafb;
            font-weight: bold;
            border-top: 1px solid #eaecf0;
        }

        .ref {
            color: #98a2b3;
            font-size: 9.5px;
        }

        .muted {
            color: #667085;
        }

        .text-center { text-align: center; }
        .text-end { text-align: right; }
        .nowrap { white-space: nowrap; }

        /* Photos : vignettes de même largeur, légende sous l'image */
        .shots {
            margin-top: 8px;
        }

        .shot {
            padding: 0 5px 10px 5px;
            vertical-align: top;
        }

        .shot .frame {
            border: 1px solid #eaecf0;
            border-radius: 6px;
            padding: 4px;
            background: #ffffff;
        }

        .shot img {
            width: 100%;
            border-radius: 4px;
        }

        .shot .caption {
            font-size: 9.5px;
            color: #475467;
            padding: 4px 2px 0 2px;
        }

        .shot .caption .num {
            color: {{ $accent }};
            font-weight: bold;
        }

        /* Contenu markdown */
        .md h1, .md h2, .md h3, .md h4, .md h5, .md h6 {
            color: #101828;
            margin: 8px 0 3px 0;
            border: 0;
        }

        .md h1 { font-size: 14px; }
        .md h2 { font-size: 13px; }
        .md h3 { font-size: 12px; }
        .md h4, .md h5, .md h6 { font-size: 11.5px; }

        .md p { margin: 0 0 5px 0; }
        .md ul, .md ol { margin: 0 0 6px 0; padding-left: 16px; }
        .md li { margin-bottom: 2px; }

        .md blockquote {
            margin: 0 0 6px 0;
            padding: 3px 10px;
            border-left: 3px solid #eaecf0;
            color: #667085;
        }

        .md code {
            background: #f2f4f7;
            border-radius: 3px;
            padding: 0 3px;
            font-size: 10.5px;
        }

        .md pre {
            background: #f9fafb;
            border: 1px solid #eaecf0;
            border-radius: 5px;
            padding: 7px 9px;
            font-size: 10px;
            color: #344054;
            white-space: pre-wrap;
        }

        .md pre code { background: transparent; padding: 0; }

        .md table { margin-bottom: 6px; }
        .md th, .md td { border: 1px solid #eaecf0; padding: 4px 6px; }
        .md th { background: #f2f4f7; }

        .avoid-break { page-break-inside: avoid; }
    </style>
</head>

<body>
    {{-- Bandeau répété sur chaque page --}}
    <div class="band">
        <table class="plain">
            <tr>
                @if ($logo)
                    <td width="62">
                        <div class="logo-box">
                            <img src="{{ $logo }}" alt="" style="max-width: 42px; max-height: 42px; margin-top: 4px;">
                        </div>
                    </td>
                @endif
                <td>
                    <div class="societe">{{ $societe }}</div>
                    @if (env('EMAIL'))
                        <div class="baseline">{{ env('EMAIL') }}@if (env('PHONE')) · {{ env('PHONE') }}@endif</div>
                    @endif
                </td>
                <td class="text-end">
                    <div class="doc">{{ $title }}</div>
                    <div class="date">{{ $journal->formatDate() }}</div>
                </td>
            </tr>
        </table>
    </div>

    {{-- Pied répété sur chaque page --}}
    <div class="foot">
        <table class="plain">
            <tr>
                <td>
                    {{ $societe }}@if (env('EMAIL')) · {{ env('EMAIL') }}@endif
                    @if (env('NINEA')) · {{ env('NINEA') }}@endif
                </td>
                <td class="text-end">{{ $journal->projet->client->name ?? '' }} · page <span class="page"></span></td>
            </tr>
        </table>
    </div>

    {{-- Client, projet, type --}}
    <table class="plain">
        <tr>
            <td width="34%" style="padding-right: 6px;">
                <div class="card">
                    <div class="label">Client</div>
                    <div class="value">{{ $journal->projet->client->name ?? '—' }}</div>
                </div>
            </td>
            <td width="40%" style="padding-right: 6px;">
                <div class="card">
                    <div class="label">Projet</div>
                    <div class="value">{{ $journal->projet->name ?? '—' }}</div>
                </div>
            </td>
            <td>
                <div class="card">
                    <div class="label">Date</div>
                    <div class="value">{{ $journal->formatDate() }}</div>
                </div>
            </td>
        </tr>
    </table>

    <h1 class="journal">{{ $journal->title }}</h1>
    <div class="journal-meta">
        @if ($journal->type)<span class="pill pill-accent">{{ $journal->type }}</span>@endif
        <span class="pill">{{ $journal->sections->count() }} section(s)</span>
        <span class="pill">{{ $journal->tasks->count() }} tâche(s)</span>
    </div>

    @if ($journal->description)
        <div class="md">
            <x-markdown>{{ $journal->description }}</x-markdown>
        </div>
    @endif

    {{-- Intervenants --}}
    @if ($journal->intervenants->count())
        <div class="part">Intervenants</div>
        <div>
            @foreach ($journal->intervenants as $intervenant)
                @php
                    $personne = $intervenant->contact ?? $intervenant->team;
                    $role = $intervenant->contact?->fonction ?? $intervenant->contact?->societe;
                @endphp
                @if ($personne)
                    <span class="pill pill-accent" style="margin-right: 4px;">
                        {{ $personne->firstname }} {{ strtoupper($personne->lastname) }}@if ($role) — {{ $role }}@endif
                    </span>
                @endif
            @endforeach
        </div>
    @endif

    {{-- Sections : description, photos et tâches --}}
    @if ($journal->sections->count())
        <div class="part">Déroulé</div>
        @foreach ($journal->sections->sortBy('order') as $section)
            <div class="section-title">
                <span class="section-num">{{ $loop->iteration }}</span>{{ $section->name }}
            </div>

            @if ($section->description)
                <div class="md">
                    <x-markdown>{{ $section->description }}</x-markdown>
                </div>
            @endif

            @include('_pdf.journal_photos', ['photos' => $section->images, 'prefixe' => $loop->iteration . '.'])

            @if ($section->tasks->count())
                <table class="data avoid-break" style="margin-top: 6px;">
                    <tbody>
                        @foreach ($section->tasks as $task)
                            <tr @class(['alt' => $loop->odd])>
                                <td>{{ $task->name }}</td>
                                <td width="90" class="text-end">
                                    <span class="pill {{ $task->statut_id >= 4 ? 'pill-done' : 'pill-wait' }}">{{ $task->statut->name ?? '' }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        @endforeach
    @endif

    {{-- Photos rattachées au journal et non à une section --}}
    @php $photosJournal = $journal->images->whereNull('journal_section_id'); @endphp
    @if ($photosJournal->count())
        <div class="part">Photos</div>
        @include('_pdf.journal_photos', ['photos' => $photosJournal])
    @endif

    {{-- Devis rattachés --}}
    @if ($journal->invoices->count())
        <div class="part">Devis</div>
        @foreach ($journal->invoices as $devis)
            @php $totalDevis = 0; @endphp
            <div class="section-title">
                {{ strtoupper($devis->reference) }}
                @if ($devis->statut)<span class="pill pill-accent" style="margin-left: 4px;">{{ $devis->statut }}</span>@endif
            </div>
            <div class="muted" style="margin-bottom: 4px;">{{ $devis->description }}</div>

            <table class="data">
                <thead>
                    <tr>
                        <th>Désignation</th>
                        <th width="50" class="text-center">Qté</th>
                        <th width="80" class="text-end">Prix</th>
                        <th width="90" class="text-end">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($devis->sections->sortBy('ordre') as $section)
                        @continue(! $section->rows->count())
                        <tr class="group">
                            <th colspan="4">{{ $section->section }}</th>
                        </tr>
                        @foreach ($section->rows->sortBy('priorite_id') as $row)
                            @php
                                $ligne = $row->quantite * $row->coef * $row->prix;
                                $totalDevis += $ligne;
                            @endphp
                            <tr @class(['alt' => $loop->odd])>
                                <td>
                                    <div>{{ $row->designation }}</div>
                                    @if ($row->reference)<div class="ref">{{ strtoupper($row->reference) }}</div>@endif
                                </td>
                                <td class="text-center">{{ $row->quantite }}</td>
                                <td class="text-end nowrap">{{ number_format($row->prix * $row->coef, 0, '.', ' ') }} F</td>
                                <td class="text-end nowrap">{{ number_format($ligne, 0, '.', ' ') }} F</td>
                            </tr>
                        @endforeach
                    @endforeach
                    <tr class="total">
                        <td colspan="3">Total</td>
                        <td class="text-end nowrap">{{ number_format($totalDevis, 0, '.', ' ') }} F</td>
                    </tr>
                </tbody>
            </table>

            @if ($devis->modalite)
                <div class="muted" style="margin-top: 4px;"><b>Modalités :</b> {{ $devis->modalite }}</div>
            @endif
        @endforeach
    @endif

    {{-- Tâches du journal qui ne sont rattachées à aucune section --}}
    @php $tachesLibres = $journal->tasks->whereNull('journal_section_id'); @endphp
    @if ($tachesLibres->count())
        <div class="part">Tâches</div>
        <table class="data">
            <thead>
                <tr>
                    <th width="26" class="text-center">#</th>
                    <th>Description</th>
                    <th width="90" class="text-center">Statut</th>
                    <th width="80" class="text-center">Priorité</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tachesLibres as $task)
                    <tr @class(['alt' => $loop->odd])>
                        <td class="text-center muted">{{ $loop->iteration }}</td>
                        <td>
                            <div>{{ $task->name }}</div>
                            @if ($task->description)<div class="ref">{{ strip_tags($task->description) }}</div>@endif
                        </td>
                        <td class="text-center">
                            <span class="pill {{ $task->statut_id >= 4 ? 'pill-done' : 'pill-wait' }}">{{ $task->statut->name ?? '' }}</span>
                        </td>
                        <td class="text-center"><span class="pill">{{ $task->priority->name ?? '' }}</span></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    {{-- Achats à effectuer --}}
    @if ($journal->achats->count())
        <div class="part">Achats à effectuer</div>
        @foreach ($journal->achats as $achat)
            @php $totalAchat = 0; @endphp
            <div class="section-title">{{ $achat->name }}</div>
            @if ($achat->description)
                <div class="md"><x-markdown>{{ $achat->description }}</x-markdown></div>
            @endif
            <table class="data">
                <thead>
                    <tr>
                        <th>Désignation</th>
                        <th width="50" class="text-center">Qté</th>
                        <th width="80" class="text-end">Prix</th>
                        <th width="90" class="text-end">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($achat->rows as $row)
                        @php $totalAchat += $row->prix * $row->quantite; @endphp
                        <tr @class(['alt' => $loop->odd])>
                            <td>
                                <div>{{ $row->article->designation ?? '' }}</div>
                                <div class="ref">{{ strtoupper($row->article->reference ?? '') }}</div>
                            </td>
                            <td class="text-center">{{ $row->quantite }}</td>
                            <td class="text-end nowrap">{{ number_format($row->prix, 0, '.', ' ') }} F</td>
                            <td class="text-end nowrap">{{ number_format($row->prix * $row->quantite, 0, '.', ' ') }} F</td>
                        </tr>
                    @endforeach
                    <tr class="total">
                        <td colspan="3">Total</td>
                        <td class="text-end nowrap">{{ number_format($totalAchat, 0, '.', ' ') }} F</td>
                    </tr>
                </tbody>
            </table>
        @endforeach
    @endif
</body>

</html>
