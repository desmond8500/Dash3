<div class="card p-2">
    <div class="row">
        <a class="col-auto cursor-pointer" href="{{ route('projets', ['client_id'=>$client->id]) }}">
            <img src="{{ $client->avatar }}" alt="A" class="avatar avatar-md">
        </a>
        <a class="col cursor-pointer" href="{{ route('projets', ['client_id'=>$client->id]) }}">
            <div class="fw-bold">{{ $client->name }} {{ $client->id }}</div>
            <div class="text-primary">{{ $client->type }}</div>
            <div>{{ $client->projets->count() }}</div>
        </a>
        <div class="col-auto">
            <button class="btn btn-primary btn-icon" wire:click="edit({{ $client->id }})">
                <i class="ti ti-edit"></i>
            </button>
        </div>
        <div class="col-md-12">
            <div class="text-muted">{{ nl2br($client->description) }}</div>
        </div>
    </div>
</div>
