<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.colors.min.css">
    <link rel="stylesheet" src="{{ asset("css/tasks.css") }}">
    <title>Tasks</title>
</head>

<style>
    body{
        font-size: 12px;
    }

    .badge{
        font-size: 9px;
        background-color: #e9ecef;
        padding: 2px 4px;
        border-radius: 4px;
    }

    .date{
        font-size: 9px;
        background-color: #e9ecef;
        padding: 2px 4px;
        border-radius: 4px;
        text-align: center;
        margin-bottom: 2px;
    }

    .text-center{
        text-align: center;
    }
</style>

<body class="container">
    <nav>
        <ul>
            <li>
                <h3>{{ $client->name }} </h3>
            </li>
        </ul>
        <ul>
            <li>
                <h6>{{ date("d-m-Y") }} </h6>
                {{-- <div>{{ date("j F Y") }} </div> --}}
            </li>
        </ul>
    </nav>

    <div class="">
        <div class="border" >
            <table class="striped" >
                <thead data-theme="dark">
                    <tr class="bg-primary text-light">
                        <th class="text-white">Site</th>
                        <th class="text-white">Taches</th>
                        <th class="text-white">Description</th>
                        <th class="text-white">Statut</th>
                        <th class="text-center">Dates</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($client->projets->sortBy('name') as $projet)
                        @if ($projet->activeClientTask())
                            @foreach ($projet->tasks as $task)
                                @if ($task->statut_id == 1 || $task->statut_id ==2)
                                    <tr class="">
                                            <td >{{ $projet->name }} </td>
                                            {{-- <td rowspan="{{ $projet->activeClientTaskCount() }}">{{ $projet->name }} </td> --}}

                                        <td class="fs-4">{{ $task->name }}</td>
                                        <td class="fs-4">{!! nl2br($task->description) !!}</td>
                                        <td scope="row" class="fs-6">
                                            <div class="badge">
                                                {{ $task->statut->name }}
                                            </div>
                                        </td>
                                        <td width=100px>
                                            @if ($task->start_date && $task->start_date !=1)
                                                <div class="date">
                                                    <div>Début</div>
                                                    <div>{{ $task->start_date }}</div>
                                                </div>
                                            @endif
                                            @if ($task->end_date && $task->end_date !=1)
                                                <div class="date">
                                                    <div>Fin</div>
                                                    <div>{{ $task->end_date }}</div>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

</body>

</html>
