<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <title>Installations</title>
</head>

<body class="container">

        <div>
            <div class="mt-2 border rounded p-2">
                <div class="row ">
                    <div class="col-auto">
                        <img src="{{ public_path($projet->client->avatar) }}" alt="Logo" style="max-width: 100px;">
                    </div>
                    <div class="col-md">
                        <div ">
                            <div class="fw-bold text-uppercase"> {{ $projet->client->name }}</div>
                            <div class="fw-bold">{{ $projet->name }}</div>
                            <div>{{ $projet->description }}</div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <h3>INSTALLATIONS</h3>
                        <div>
                            <div class="text-end">{{ $projet->updated_at->format('d/m/Y') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- @foreach ($installations as $installation)

                <div class="row g-2 mt-2 ">
                    @foreach ($installation->objets as $objet)
                        <div class="col-md-4">
                            <div class="card h-100" >
                                <div class="card-header">
                                    <div class="card-title fw-bold">{{ ucfirst($objet->name) }}</div>
                                    <div class="card-subtitle mb-2 text-muted">{{ ucfirst($objet->description) }}</div>

                                </div>
                                <div class="p-2 ">

                                    <table class="table  table-sm mt-2">
                                        <tbody>
                                            @foreach ($objet->valeurs as $valeur)
                                            <tr>
                                                <td style="padding:0px" class="fw-bold">{{ $valeur['name'] }}</td>
                                                <td style="padding:0px">{{ $valeur['value'] }}</td>

                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach --}}

            <div class="row g-2">
                @foreach ($installations as $installation)
                    <div class="col-md-6">
                        <div class="mt-2 border rounded p-2 mb-2" style="font-size: 10px">
                            <div style="background: lightgray; border-radius: 5px 5px 0px 0px" class="p-2">
                                <div class="fw-bold" style="font-size:15px;">{{ $installation->systeme->name }}</div>
                                <div>{!! nl2br($installation->description) !!}</div>
                            </div>

                            <table class="table border-primary table-sm mt-2">
                                <thead>
                                    <tr class="">
                                        <th>Nom</th>
                                        <th>Attributs</th>
                                    </tr>
                                </thead>
                                @foreach ($installation->objets as $objet)
                                <tr class="">
                                    <td>
                                        <div class="fw-bold">{{ ucfirst($objet->name) }}</div>
                                        <div>{{ ucfirst($objet->description) }}</div>
                                    </td>
                                    <td style="padding:5px">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tbody>
                                                    @foreach ($objet->valeurs as $valeur)
                                                    <tr>
                                                        <td style="padding:0px" class="fw-bold">{{ $valeur['name'] }}</td>
                                                        <td style="padding:0px">{{ $valeur['value'] }}</td>

                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>


                                        </div>

                                    </td>

                                </tr>
                                @endforeach
                            </table>

                        </div>

                    </div>

                @endforeach

            </div>

        </div>




        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
        </script>
    </body>

    </html>




    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
</body>

</html>
