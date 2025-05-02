<table>
    <thead>
        <tr>
            <th>Désignation</th>
            <th>Reference </th>
            <th>Coef </th>
            <th>Quantite </th>
            <th>Prix </th>
            <th>invoice_section_id </th>
            <th>priorite_id </th>
            <th>article_id </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($rows as $row)
            <tr>
                <td>{{ $row->designation }}</td>
                <td>{{ $row->reference }}</td>
                <td>{{ $row->quantite }}</td>
                <td>{{ $row->coef }}</td>
                <td>{{ $row->prix }}</td>
                <td>{{ $row->invoice_section_id }}</td>
                <td>{{ $row->priorite_id }}</td>
                <td>{{ $row->article_id ?? 0 }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
