<div class="row g-2">
    <div class="col-md-12">
        <div class="card p-2">
            <div class="row">
                <div class="col-auto">
                    <img class="avatar avatar-md" src="{{ asset($projet->client->avatar) }}" alt="A">
                </div>
                <div class="col">
                    <h4>{{ $projet->name }}</h4>
                    <p>{{ nl2br($projet->description) }}</p>
                </div>
                <div class="col-auto">
                    <button class="btn btn-primary btn-icon">
                        <i class="ti ti-edit"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card p-2">
            <div class="row">
                <div class="col">
                    <h2>Devis</h2>
                    <ul>
                        <li>Nouveaux devis</li>
                        <li>Devis en cours</li>
                    </ul>
                </div>
                <div class="col-auto">
                    <button class="btn btn-primary btn-icon">
                        <i class="ti ti-edit"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-2">
            <div class="row">
                <div class="col">
                    <h4>Taches</h4>
                    <ul>
                        <li>Nouvelles taches</li>
                        <li>Taches en cours</li>
                    </ul>
                </div>
                <div class="col-auto">
                    <button class="btn btn-primary btn-icon">
                        <i class="ti ti-edit"></i>
                    </button>
                </div>
            </div>

        </div>

    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Building management</div>
                <div class="card-actions">
                    <button class="btn btn-primary" > <i class="ti ti-plus"></i> Batiment</button>
                </div>
            </div>
            <div class="card-body">
                <a href="{{ route('buildings', ['projet_id'=>$projet->id]) }}">Consulter</a>

            </div>
            <div class="card-footer">

            </div>
        </div>
    </div>
</div>
