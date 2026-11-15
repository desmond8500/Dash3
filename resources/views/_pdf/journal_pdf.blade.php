<!DOCTYPE html>
<html lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/table.css">
    <link rel="stylesheet" href="css/pdf.css">
    <link rel="stylesheet" href="css/text.css">
    <link rel="stylesheet" href="css/journal_pdf.css">
    <title>Journal</title>

</head>
<body>
    @php
        $total = 0;
        $tva = 0;
        $carbon->locale('fr_FR');
    @endphp

    <table class="table" style="margin-bottom: 10px;">
        <tr>
            <td width="80px" class="border_white">
                @if ($logo)
                    <div style="width: 80px; height: 80px;" >
                        <img src="{{ public_path('img/tyto/logo.png') }}" alt="logo" style="width:100%; height:100%;">
                    </div>
                @else
                    <div class="logo"  style="background: #{{ $color1 }}">
                        <div class="text-center" style="padding-top: 30px;">Logo</div>
                    </div>
                @endif
            </td>
            <td width="300px" class="border_white fw-bold" align="left" style="{{ $title_css }}; color: #{{ $color1 }}" >
                <div>{{ env('MAIN_NAME') }}</div>
            </td>
            <td align="right" class="border_white">
                <div class="doc_title" style="text-transform: uppercase; color: #{{ $color1 }} ">{{ $title }}</div>
                <i>{{ $journal->formatDate() }}</i>
            </td>
        </tr>
    </table>

    <hr>
    <div>
        <span class="fw-bold">Client : </span> <span>{{ $journal->projet->client->name }}</span> <br>
        <span class="fw-bold">Projet : </span> <span>{{ $journal->projet->name }}</span>
    </div>

    <div class="journal_title" style="color: #{{ $color1 }}">
        {{ $journal->title }}
    </div>

    @if ($journal->intervenants->count())
        <div>
            <h1>Intervenants</h1>
            <ul type='dot'>
                @foreach ($journal->intervenants as $intervenant)
                    @if ($intervenant->contact_id)
                        <li>{{ $intervenant->contact->firstname }} {{ strtoupper($intervenant->contact->lastname) }}  ({{ $intervenant->contact->fonction }})</li>
                    @else
                        <li>{{ $intervenant->team->firstname }} {{ strtoupper($intervenant->team->lastname) }} </li>
                    @endif
                @endforeach
            </ul>

        </div>

    @endif

    <div>
        <x-markdown>
         {{ $journal->description }}
        </x-markdown>
    </div>

    @foreach ($journal->sections->sortBy('order') as $section)
        <h1>{{ $section->name }}</h1>
        <x-markdown>
         {{ $section->description }}
        </x-markdown>

        {{-- Photos de la section --}}
        @include('_pdf.journal_photos', ['photos' => $section->images])

        {{-- Tâches de la section --}}
        @if ($section->tasks->count())
            <table class="table" style="font-size:13px; margin-top: 6px;">
                <tbody>
                    @foreach ($section->tasks as $task)
                        <tr>
                            <td width="15px" class="text-center">{{ $task->statut_id >= 4 ? 'X' : 'O' }}</td>
                            <td>{{ $task->name }}</td>
                            <td width="90px" class="text-center text-primary">{{ $task->statut->name ?? '' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @endforeach

    {{-- Photos rattachées au journal et non à une section --}}
    @php $photosJournal = $journal->images->whereNull('journal_section_id'); @endphp
    @if ($photosJournal->count())
        <h1>Photos</h1>
        @include('_pdf.journal_photos', ['photos' => $photosJournal])
    @endif


    {{-- Devis rattachés au journal : sections, lignes et total --}}
    @if ($journal->invoices->count())
        <h1>Devis</h1>
        @foreach ($journal->invoices as $devis)
            @php $totalDevis = 0; @endphp
            <div class="fw-bold" style="margin-top: 6px;">
                {{ strtoupper($devis->reference) }}
                @if ($devis->statut) <span class="text-gray">— {{ $devis->statut }}</span> @endif
            </div>
            <div class="text-gray fs-7">{{ $devis->description }}</div>

            <table class="table" style="font-size:13px; margin-top: 4px;">
                <thead class="thead">
                    <tr>
                        <th>Désignation</th>
                        <th width='60px' class="text-center">Qté</th>
                        <th width='80px' class="text-center">Prix</th>
                        <th width='90px' class="text-center">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($devis->sections->sortBy('ordre') as $section)
                        @continue(! $section->rows->count())
                        <tr>
                            <th colspan="4" style="background: #eeeeee;">{{ $section->section }}</th>
                        </tr>
                        @foreach ($section->rows->sortBy('priorite_id') as $row)
                            @php
                                $ligne = $row->quantite * $row->coef * $row->prix;
                                $totalDevis += $ligne;
                            @endphp
                            <tr>
                                <td>
                                    <div class="task_name">{{ $row->designation }}</div>
                                    <div class="task_description fs-7">{{ strtoupper($row->reference) }}</div>
                                </td>
                                <td class="text-center">{{ $row->quantite }}</td>
                                <td class="text-center">{{ number_format($row->prix * $row->coef, 0, '.', ' ') }} F</td>
                                <td class="text-center">{{ number_format($ligne, 0, '.', ' ') }} F</td>
                            </tr>
                        @endforeach
                    @endforeach
                    <tr>
                        <td colspan="3"><b>TOTAL</b></td>
                        <td class="text-center"><b>{{ number_format($totalDevis, 0, '.', ' ') }} F</b></td>
                    </tr>
                </tbody>
            </table>

            @if ($devis->modalite)
                <div class="fs-7"><span class="fw-bold">Modalités : </span>{{ $devis->modalite }}</div>
            @endif
            <br>
        @endforeach
    @endif

    @if ($journal->tasks->count())
        <h1>Taches</h1>

        <table class="table" style="font-size:13px">
            <thead class="thead">
                <tr>
                    <th width='15px'>#</th>
                    <th>Description de la tache</th>
                    <th width='70px' class="text-center">Statut</th>
                    <th width='70px'>Priorité</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($journal->tasks as $key => $task)
                    <tr>
                        <td class="text-center">{{ $key + 1 }}</td>
                        <td>
                            <div class="task_name">{{ $task->name }}</div>
                            <div class="task_description">{!! $task->description !!}</div>
                        </td>
                        <td class="text-center">
                            <div class="text-primary">
                                <div class="task_statut fs-7">{{ $task->statut->name }}</div>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="text-purple">
                                <div class="task_priority fs-7">{{ $task->priority->name }}</div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if ($journal->achats->count())
        <h1>Achats à effectuer</h1>
        @foreach ($journal->achats as $key => $achat)
            <div class="text-gray fs-6">
                <div class="text-primary">{{ $achat->name }}</div>
                <x-markdown>
                 {{ $achat->description }}
                </x-markdown>
            </div>

            <table class="table" style="font-size:13px">
                <thead class="thead">
                    <tr>
                        <th width='15px'>#</th>
                        <th>Désignation</th>
                        <th width='70px' class="text-center">Quantité</th>
                        <th width='70px' class="text-center">Prix</th>
                        <th width='70px'>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $total = 0;
                    @endphp
                    @foreach ($achat->rows as $key => $row)
                        <tr>
                            <td class="text-center">{{ $key + 1 }}</td>
                            <td>
                                <div class="task_name fw-bold fs-7">{{ $row->article->designation }}</div>
                                <div class="task_description fs-7">{{ strtoupper($row->article->reference) }}</div>
                            </td>
                            <td class="text-center">
                                <div class="task_statut fs-7">{{ $row->quantite }}</div>
                            </td>
                            <td class="text-center">
                                <div class="task_priority fs-7">{{ number_format($row->prix, 0,'.', ' ') }} F</div>
                            </td>
                            <td class="text-center">
                                <div class="task_priority fs-7">{{ number_format($row->prix* $row->quantite, 0,'.', ' ') }} F</div>
                            </td>
                        </tr>
                        @php
                            $total += $row->prix* $row->quantite;
                        @endphp
                    @endforeach
                    <tr>
                        <td class="text-center"></td>
                        <td colspan="2">
                            <b>TOTAL</b>
                        </td>
                        <td class="text-center" colspan="2">
                            <div class="task_priority fw-bold fs-7">{{ number_format($total, 0,'.', ' ') }} F</div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <br>

        @endforeach

    @endif

</body>
</html>
