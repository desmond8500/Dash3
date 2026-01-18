{{-- HEADER --}}
<style>
    .header {
    width: 100%;
    margin-bottom: 20px;
    }

    .company {
    width: 60%;
    float: left;
    }

    .company h2 {
    margin: 0;
    font-size: 18px;
    }

    .company p {
    margin: 2px 0;
    }

    .doc-info {
    width: 40%;
    float: right;
    text-align: right;
    }

</style>

<div class="header">
    <div class="company">
        <h2>{{ config('app.name') }}</h2>
        <p>Adresse : {{ $entreprise->adresse ?? "Adresse" }}</p>
        <p>Tél : {{ $entreprise->telephone ?? 'Telephone' }}</p>
        <p>Email : {{ $entreprise->email ?? 'Email' }}</p>
    </div>

    <div class="doc-info">
        <p><strong>Devis N° :</strong> {{ $devis->reference ?? "REFERENCE" }}</p>
        <p><strong>Date :</strong> {{ $devis->date->format('d/m/Y') ?? "DATE" }}</p>
        {{-- <p><strong>Validité :</strong> {{ $devis->validite ?? "0" }} jours</p> --}}
    </div>
</div>

