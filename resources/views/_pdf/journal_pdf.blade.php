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
                        <img src="{{ $logo }}" alt="logo" style="width:100%; height:100%;">
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
                        <li>{{ $intervenant->team->firstname }} {{ $intervenant->team->lastname }} </li>
                    @endif
                @endforeach
            </ul>

        </div>

    @endif

    <div>
        @parsedown($journal->description)
    </div>

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

</body>
</html>
