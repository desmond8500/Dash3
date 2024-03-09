<div class="row g-2">
    <div class="col-md-4">
        <div class="card p-2 mb-2">
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

        <div class="card p-2 mb-2">
            <div class="row">
                <div class="col">
                    <h2>Devis</h2>
                    <ul>
                        <li>Nouveaux devis</li>
                        <li>Devis en cours</li>
                    </ul>
                </div>

            </div>
        </div>

        <div class="card p-2 mb-2">
            <div class="row">
                <div class="col">
                    <h2>Taches </h2>
                    <ul>
                        <li>Nouvelles taches {{ $projet->tasks->count() }}</li>
                        <li>Taches en cours</li>
                    </ul>
                </div>
                <div class="col-auto">
                    @livewire('form.task-add', ['projet_id' => $projet->id])
                </div>
            </div>
        </div>

    </div>
    <div class="col-md-8">

        <div class="card">
            <div class="card-header">
                <div class="card-title"><h2>Building management</h2> </div>
                <div class="card-actions">
                    @livewire('form.building-add', ['projet_id' => $projet->id])
                </div>
            </div>
            <div class="p-2">
                <div class="row row-deck g-2">

                    @foreach ($buildings as $building)
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title"><a href="{{ route('building', ['building_id'=> $building->id]) }}">{{ $building->name }}</a> </h3>
                                    <div class="card-actions">
                                        {{-- @livewire('form.stage-add', ['building_id' => $building->id, key($building->id)]) --}}
                                    </div>
                                </div>
                                <div class="p-2">
                                    <span class="text-muted"> {{ nl2br($building->description) }} </span>

                                </div>
                                <div class="p-2">
                                    <li class="d-flex justify-content-between  btn btn-primary p-2 rounded mb-1">
                                        <span class="fw-bold">Niveaux: </span> <span class="badge bg-white text-primary">{{ $building->stages->count() }}</span>
                                    </li>
                                    <li class="d-flex justify-content-between  btn btn-primary p-2 rounded mb-1">
                                        <span class="fw-bold">Taches: </span> <span class="badge bg-white text-primary">{{ $building->tasks->count() }}</span>
                                    </li>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</div>
