<div class="card p-2 ">
    <div class="row">
        <a class="col-auto" href="{{ route('projet',['projet_id'=> $projet->id]) }}">
            <img class="avatar " src="{{ asset($projet->client->avatar) }}" alt="A">
        </a>
        <a class="col" href="{{ route('projet',['projet_id'=> $projet->id]) }}" style="text-decoration: none">
            <div class="fw-bold">{{ $projet->name }}</div>
        </a>
        <div class="col-md-12">
            <div class="text-muted mt-1">{{ nl2br($projet->description) }}</div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div> Devis: {{ $projet->devis->count() }}</div>
            <div> Taches: {{ $projet->tasks->count() }}</div>
        </div>
        <div class="col-auto">
            <button class="btn btn-primary btn-icon" wire:click="edit('{{ $projet->id }}')">
                <i class="ti ti-edit"></i>
            </button>
        </div>
    </div>
</div>
