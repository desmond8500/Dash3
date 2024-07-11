<table>
    <thead>
        <tr>
            <th>Désignation</th>
            <th>Reference </th>
            <th>Quantite </th>
            <th>Tarif </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($rows as $row)
        <tr>
            <td>{{ $row->designation }}</td>
            <td>{{ $row->reference }}</td>
            <td>{{ $row->quantite }}</td>
            <td>{{ $row->tarif }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
