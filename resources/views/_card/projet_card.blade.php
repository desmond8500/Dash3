<div class="card p-2 ">
    <div class="row ">
        <a class="col-auto" href="{{ route('projet',['projet_id'=> $projet->id]) }}">
            <img class="avatar " src="{{ asset($projet->client->avatar) }}" alt="A">
        </a>
        <a class="col" href="{{ route('projet',['projet_id'=> $projet->id]) }}" style="text-decoration: none">
            <div class="fw-bold">{{ $projet->name }}</div>
        </a>
        <div class="col-auto">
            <div class="dropdown open">
                <button class="btn btn-action border dropdown-toggle" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                    <i class="ti ti-dots-vertical"></i>
                </button>
                <div class="dropdown-menu" aria-labelledby="triggerId">
                    <button class="dropdown-item" wire:click="edit('{{ $projet->id }}')"> <i class="ti ti-edit me-2"></i> Editer</button>
                    <button class="dropdown-item disabled" > <i class="ti ti-trash me-2"></i> Supprimer</button>
                </div>
            </div>

        </div>
        {{-- <div class="col-md-12">
            <div class="text-muted mt-1">{{ nl2br($projet->description) }}</div>
        </div> --}}
    </div>
    <div class="d-flex justify-content-between bg-blue-lt mt-2 p-1 rounded">
        <div> Devis: {{ $projet->devis->count() }}</div>
        <div> Taches: {{ $projet->tasks->count() }}</div>
    </div>
</div>
