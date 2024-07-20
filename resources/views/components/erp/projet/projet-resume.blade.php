<div class="row g-2">
    <div class="col-md-4">
        <div class="card p-2 mb-2">
            <div class="row">
                <div class="col-auto">
                    <img class="avatar avatar" src="{{ asset($projet->client->avatar) }}" alt="A">
                </div>
                <div class="col">
                    <h4>{{ $projet->name }}</h4>

                </div>
                <div class="col-auto">
                    <div class="dropdown open">
                        <button class="btn btn-action border dropdown-toggle" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                            <i class="ti ti-dots-vertical"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="triggerId">
                            <button class="dropdown-item" wire:click="edit('{{ $projet->id }}')">Editer</button>
                        </div>
                    </div>
                    <div class="dropdown-menu" aria-labelledby="triggerId">
                        <button class="dropdown-item" wire:click="edit('{{ $projet->id }}')">Editer</button>
                    </div>
                </div>
                <div class="col-md-12">
                    <p class="mt-2">{{ nl2br($projet->description) }}</p>
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
        @livewire('erp.building-list', ['projet_id' => $projet->id])
    </div>


</div>
