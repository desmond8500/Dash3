
<div class="card p-1 bg-light rounded border-primary red_hover" >
    <div class="bg-{{ $client->type == 'Entreprise' ? "primary" : 'cyan' }} p-2 rounded">
        <div class="row ">
            <a class="col-auto cursor-pointer" href="{{ route('projets', ['client_id'=>$client->id ?? 1]) }}">
                <img src="{{ $client->avatar ?? 'img/icons/user4.png' }}" alt="C" class="avatar p-1">
            </a>
            <a class="col cursor-pointer text-white" href="{{ route('projets', ['client_id'=>$client->id ?? 1]) }}" style="text-decoration: none">
                <div class="">{{ $client->type ?? 'Type' }}</div>
                <div class="fw-bold">{{ $client->name ?? 'Nom' }}</div>
            </a>
            <div class="col-auto">
                {{-- <button class="btn btn-light btn-icon" wire:click="edit('{{ $client->id ?? 1 }}')"><i class="ti ti-edit"></i></button> --}}

                <div class="dropdown open" wire:navigated>
                    <button class="btn btn-action" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                        <i class="ti ti-chevron-down text-white"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="triggerId">
                        <button class="dropdown-item" wire:click="edit('{{ $client->id ?? 1 }}')"> <i class="ti ti-edit"></i> Editer</button>
                        <button class="dropdown-item text-danger" wire:click="delete('{{ $client->id ?? 1 }}')"> <i class="ti ti-trash"></i> Supprimer</button>
                        <button class="dropdown-item" wire:click="toggleFavorite('{{ $client->id }}')">
                            @if ($client->favorite)
                                <div class="text-danger"><i class="ti ti-heart-filled"></i> Favoris</div>
                            @else
                                <div class="text-muted"><i class="ti ti-heart"></i> Favoris</div>
                            @endif
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between p-2">
        @isset ($client)
            <div> <i class="ti ti-box"></i> Projets: <b>{{ $client->projets->count() }}</b></div>
            <div> <i class="ti ti-box"></i> Taches: <b>{{ $client->tasks->count() }}</b></div>
        @endisset
    </div>

</div>
