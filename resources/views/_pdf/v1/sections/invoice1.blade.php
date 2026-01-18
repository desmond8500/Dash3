{{-- LIGNES DE DEVIS --}}

<style>
    table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
    }

    table th,
    table td {
    border: 1px solid #000;
    padding: 6px;
    }

    table th {
    background-color: #f0f0f0;
    text-align: left;
    }

    .text-right {
    text-align: right;
    }

    .totals {
    width: 40%;
    float: right;
    }

    .totals table td {
    border: none;
    padding: 4px;
    }

    .totals .label {
    text-align: right;
    }

    .totals .value {
    text-align: right;
    font-weight: bold;
    }

    .title {
    text-align: center;
    margin: 30px 0 20px;
    font-size: 20px;
    font-weight: bold;
    text-transform: uppercase;
    }

    .client-box {
    border: 1px solid #000;
    padding: 10px;
    margin-bottom: 20px;
    }


    .text-right {
    text-align: right;
    }
</style>

{{-- TITRE --}}
<div class="title">
    Devis
</div>

{{-- CLIENT --}}
<div class="client-box">
    <strong>Client :</strong><br>
    {{ $devis->client->nom ?? "Nom du client" }}<br>
    {{ $devis->client->adresse ?? "Adresse du client" }}<br>
    {{ $devis->client->telephone ?? "Téléphone du client" }}
</div>

<table>
    <thead>
        <tr>
            <th style="width:5%">#</th>
            <th style="width:45%">Désignation</th>
            <th style="width:10%">Qté</th>
            <th style="width:15%">Prix unitaire</th>
            <th style="width:10%">TVA</th>
            <th style="width:15%">Total</th>
        </tr>
    </thead>
    <tbody>
        {{-- @foreach([] as $index => $ligne) --}}
        @foreach($devis->lignes as $index => $ligne)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $ligne->designation }}</td>
            <td class="text-right">{{ $ligne->quantite }}</td>
            <td class="text-right">{{ number_format($ligne->prix_unitaire, 0, ',', ' ') }}</td>
            <td class="text-right">{{ $ligne->tva ?? 0 }} %</td>
            <td class="text-right">
                {{ number_format($ligne->total, 0, ',', ' ') }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{-- TOTAUX --}}
<div class="totals">
    <table>
        <tr>
            <td class="label">Sous-total HT :</td>
            <td class="value">{{ number_format($devis->total_ht, 0, ',', ' ' ?? 0) }}</td>
        </tr>
        <tr>
            <td class="label">TVA :</td>
            <td class="value">{{ number_format($devis->total_tva, 0, ',', ' ' ?? 0) }}</td>
        </tr>
        <tr>
            <td class="label">Total TTC :</td>
            <td class="value">{{ number_format($devis->total_ttc, 0, ',', ' ' ?? 0) }}</td>
        </tr>
    </table>
</div>
{{-- CONDITIONS --}}
<p>
    <strong>Conditions :</strong><br>
    {{ $devis->conditions }}
</p>
