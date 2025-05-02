<div>
    <div class="row">
        <div class="col-auto">
            <h3>ID: {{ $device->id }}</h3>
        </div>
        <div class="col">
            {{ $device->designation }}
        </div>
        <div class="col-auto">
            QR Code
        </div>
    </div>

    <div>
        Client:
    </div>
    <div>
        Projet:
    </div>





    <table class="table table-hover">
        <tbody>
            <tr>
                <td>Désignation</td>
                <td>{{ $device->designation }}</td>
            </tr>
            <tr>
                <td>Référence</td>
                <td>{{ $device->reference }}</td>
            </tr>
            <tr>
                <td>SN</td>
                <td>{{ $device->serial_number }}</td>
            </tr>
            <tr>
                <td>Tirage</td>
                <td>{{ $device->wire }}</td>
            </tr>
            <tr>
                <td>Pose</td>
                <td>{{ $device->install }}</td>
            </tr>
            <tr>
                <td>Connexion</td>
                <td>{{ $device->connect }}</td>
            </tr>
            <tr>
                <td>Configuration</td>
                <td>{{ $device->config }}</td>
            </tr>
            <tr>
                <td>Mise en service</td>
                <td>{{ $device->commisionning }}</td>
            </tr>


            <tr>


        </tbody>
    </table>
</div>
