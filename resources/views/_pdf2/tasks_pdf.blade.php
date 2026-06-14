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

    @foreach ($client->projets as $projet)
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
                            <tr class="">
                                <td scope="row">{{ $task->name }}</td>
                                <td>{!! nl2br($task->description) !!}</td>
                                <td scope="row" class="fs-6">{{ $task->statut->name }}</td>
                                <td width=80px>
                                    <div class="fs-6">{{ $task->start_date }}</div>
                                    <div class="fs-6">{{ $task->end_date }}</div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    @endforeach

</body>

</html>
