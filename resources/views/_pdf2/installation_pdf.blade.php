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
            <h1 class="h3">Installations</h1>
            <p class="mb-0">Liste des installations du projet</p>

            @foreach ($installations as $installation)
                <div class="border rounded p-2 mb-2">
                    <div>{{ $installation->name }}</div>
                    <div>{!! nl2br($installation->description) !!}</div>

                    <table class="table table-bordered  mt-2">
                        <thead>
                            <tr class="table-secondary">
                                <th>Nom</th>
                                <th>Attributs</th>
                            </tr>
                        </thead>
                        @foreach ($installation->objets as $objet)
                        <tr class="table-primary">
                            <td>
                                <div>{{ strtoupper($objet->name) }}</div>
                                <div>{{ $objet->description }}</div>
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

            @endforeach
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
