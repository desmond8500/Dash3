{{-- <div class="card p-2">
    <div class="row">
        <a class="col-auto cursor-pointer" href="{{ route('projets', ['client_id'=>$client->id]) }}">
            <img src="{{ $client->avatar }}" alt="A" class="avatar avatar-md">
        </a>
        <a class="col cursor-pointer" href="{{ route('projets', ['client_id'=>$client->id]) }}" style="text-decoration: none">
            <div class="fw-bold">{{ $client->name }}</div>
            <div class="text-muted ">{{ $client->type }}</div>
            <div> Projets: {{ $client->projets->count() }}</div>
        </a>
        <div class="col-auto">
            <button class="btn btn-primary btn-icon" wire:click="edit({{ $client->id }})">
                <i class="ti ti-edit"></i>
            </button>
        </div>
    </div>
</div> --}}

<div class="card p-1 bg-light rounded  border-primary">
    <div class="bg-primary p-2 rounded">
        <div class="row ">
            <a class="col-auto cursor-pointer" href="{{ route('projets', ['client_id'=>$client->id]) }}">
                <img src="{{ $client->avatar }}" alt="C" class="avatar">
            </a>
            <a class="col cursor-pointer text-white" href="{{ route('projets', ['client_id'=>$client->id]) }}" style="text-decoration: none">
                <div class="">{{ $client->type }}</div>
                <div class="fw-bold">{{ $client->name }}</div>
            </a>
            <div class="col-auto">
                <button class="btn btn-light btn-icon" wire:click="edit('{{ $client->id }}')"><i class="ti ti-edit"></i></button>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between p-2">
        <div> <i class="ti ti-box"></i> Projets <b>{{ $client->projets->count() }}</b></div>
        <div> <i class="ti ti-box"></i> Taches <b>{{ $client->tasks->count() }}</b></div>
    </div>

</div>
