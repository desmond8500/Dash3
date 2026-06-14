<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/css/tabler.min.css" />

    <title>Tabler demo</title>
</head>

<body class="container">
    <div class="border rounded p-2">
        <h1>{{ $client->name }}</h1>
    </div>

    @foreach ($client->projets->sortBy('name') as $projet)
        @if ($projet->activeClientTask())
            <div class="">
                <h2 class="card-title mt-2 text-primary">{{ $projet->name }}</h2>
                <div class="border" >
                    <table class="table" >
                        <thead>
                            <tr class="bg-primary text-light">
                                <th class="text-white">Taches</th>
                                <th class="text-white">Description</th>
                                <th class="text-white">Statut</th>
                                <th class="text-white">Dates</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($projet->tasks as $task)
                                @if ($task->statut_id == 1 || $task->statut_id ==2)
                                    <tr class="">
                                        <td class="fs-4">{{ $task->name }}</td>
                                        <td class="fs-4">{!! nl2br($task->description) !!}</td>
                                        <td scope="row" class="fs-6">
                                            {{ $task->statut->name }}</td>
                                        <td width=80px>
                                            @if ($task->start_date)
                                                <div class="fs-6 text-center border-bottom">
                                                    <div>Début</div>
                                                    <div>{{ $task->start_date }}</div>
                                                </div>
                                            @endif
                                            @if ($task->end_date)
                                                <div class="fs-6 text-center">
                                                    <div>Fin</div>
                                                    <div>{{ $task->end_date }}</div>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

        @endif
    @endforeach

</body>

</html>
