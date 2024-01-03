<div class="card p-2 ">
    <div class="row">
        <a class="col-auto" href="{{ route('projet',['projet_id'=> $projet->id]) }}">
            <img class="avatar " src="{{ asset($projet->client->avatar) }}" alt="A">
        </a>
        <a class="col" href="{{ route('projet',['projet_id'=> $projet->id]) }}">
            <div class="fw-bold">{{ $projet->name }}</div>
            <div>{{ $projet->devis->count() }}</div>
        </a>
        <div class="col-auto">
            <button class="btn btn-primary btn-icon" wire:click="edit('{{ $projet->id }}')">
                <i class="ti ti-edit"></i>
            </button>
        </div>
        <div class="col-md-12">
            <div class="text-muted">{{ nl2br($projet->description) }}</div>
        </div>
    </div>
</div>
