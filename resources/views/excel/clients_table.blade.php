<table>
    <thead>
        <tr >
            <th style="color: white; font-weight: bold; background: #40A2E3; border: 1px solid #40A2E3; padding: 5px;">#</th>
            <th style="color: white; font-weight: bold; background: #40A2E3; border: 1px solid #40A2E3; padding: 5px;">Nom</th>
            <th style="color: white; font-weight: bold; background: #40A2E3; border: 1px solid #40A2E3; padding: 5px;">Description</th>
            {{-- <th style="color: white; font-weight: bold; background: #40A2E3; border: 1px solid #40A2E3; padding: 5px;">Adresse</th>
            <th style="color: white; font-weight: bold; background: #40A2E3; border: 1px solid #40A2E3; padding: 5px;">Avatar</th>
            <th style="color: white; font-weight: bold; background: #40A2E3; border: 1px solid #40A2E3; padding: 5px;">Statut</th> --}}
            <th style="color: white; font-weight: bold; background: #40A2E3; border: 1px solid #40A2E3; padding: 5px;">Type</th>
        </tr>
    </thead>
    <tbody>
        @foreach($clients as $key => $client)
        <tr>
            <td style="padding: 5px; border: 1px solid #40A2E3;">{{ $key+1 }}</td>
            <td style="padding: 5px; border: 1px solid #40A2E3;">{{ $client->name }}</td>
            <td style="padding: 5px; border: 1px solid #40A2E3;">{{ $client->description }}</td>
            {{-- <td style="padding: 5px; border: 1px solid #40A2E3;">{{ $client->address }}</td>
            <td style="padding: 5px; border: 1px solid #40A2E3;">{{ $client->avatar }}</td>
            <td style="padding: 5px; border: 1px solid #40A2E3;">{{ $client->status }}</td> --}}
            <td style="padding: 5px; border: 1px solid #40A2E3;">{{ $client->type }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
