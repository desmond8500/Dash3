@extends('_pdf.bl.bl_page')

@section('content')
    <table class="table mb-1">
        <tr>
            <td colspan="4" class="text-center text-uppercase bg-green" style="background: #{{ $color1 }}"> Equipements fournis</td>
        </tr>
        <tr>
            <th class="text-center bg-grey" style="background: #{{ $color2 }}">#</th>
            <th class="bg-grey" style="background: #{{ $color2 }}">Désignation</th>
            <th class="bg-grey" style="background: #{{ $color2 }}">Référence</th>
            <th class="bg-grey" style="background: #{{ $color2 }}">Quantité</th>
        </tr>

        @php $count = 0; @endphp

        @foreach ($invoice->rows as $key => $row)
            @if ($row->priorite_id < 6) @php $count++; @endphp
                <tr>
                    <td width="15px" class="text-center">{{ $count }}</td>
                    <td>{{ $row->designation }}</td>
                    <td>{{ $row->reference }}</td>
                    <td width="10px" class="text-center">{{ $row->quantite }}</td>
                </tr>
            @endif
        @endforeach
    </table>

@endsection
