<?php

use Livewire\Volt\Component;
use App\Models\Client;
use function Livewire\Volt\{mount};
use App\Livewire\Forms\clientForm;
use Livewire\WithFileUploads;

new class extends Component {
    public int $client_id;
    public clientForm $clientForm;
    use WithFileUploads;

    public function mount(int $client_id) {
        $this->client_id = $client_id;
    }

    public function with(): array {
        return [
            'client' => \App\Models\Client::find($this->client_id),
        ];
    }

    function edit() {
        $this->clientForm->set($this->client_id);
        $this->dispatch('open-editClient');
    }

    function update() {
        $this->clientForm->update($this->client_id);
        $this->dispatch('close-editClient');
        $this->render();
    }

    function toggleFavorite($id) {
        $this->clientForm->favorite($id);
    }
}; ?>

<div>
    <div class="card p-2">
        <div class="position-absolut top-0 ">
            <div class="d-flex justify-content-between">
                <button class="btn btn-icon rounded btn-primary" wire:click="edit('{{ $client->id ?? 1 }}')">
                    <i class="ti ti-edit"></i>
                </button>
                @if ($client->favorite)
                    <button class="btn btn-icon btn-danger" data-bs-toggle="tooltip" title="Supprimer des favoris" wire:click="toggleFavorite('{{ $client->id }}')">
                        <i class="ti ti-heart-filled"></i>
                    </button>
                @else
                    <button class="btn btn-icon btn-outline-danger" data-bs-toggle="tooltip" title="Ajouter aux favoris" wire:click="toggleFavorite('{{ $client->id }}')">
                        <i class="ti ti-heart"></i>
                    </button>
                @endif
            </div>

            {{-- <button class="btn btn-action" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                <i class="ti ti-chevron-down "></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="triggerId">
                <button class="dropdown-item" wire:click="edit('{{ $client->id ?? 1 }}')"> <i class="ti ti-edit"></i>
                    Editer</button>
                <button class="dropdown-item text-danger" wire:click="delete('{{ $client->id ?? 1 }}')"> <i class="ti ti-trash"></i>
                    Supprimer</button>
                <button class="dropdown-item" wire:click="toggleFavorite('{{ $client->id }}')">
                    @if ($client->favorite)
                    <div class="text-danger"><i class="ti ti-heart-filled"></i> Favoris</div>
                    @else
                    <div class="text-muted"><i class="ti ti-heart"></i> Favoris</div>
                    @endif
                </button>
            </div> --}}
        </div>
        <img src="{{ asset($client->avatar) }}" alt="img" class="w-100">
        <h2 class="text-center mt-1 border-top mt-3 pt-1">{{ $client->name }}</h2>
        <p>{{ $client->description }}</p>

        <div class="row g-2">
            <div class="col-md-12">
            </div>

        </div>
    </div>

    @component('components.modal', ["id"=>'editClient', 'title'=>'Modifier un client', 'method'=>'update'])
    <form class="row" wire:submit="update">
        @include('_form.client_form')
    </form>
    <script> window.addEventListener('open-editClient', event => { $('#editClient').modal('show'); }) </script>
    <script> window.addEventListener('close-editClient', event => { $('#editClient').modal('hide'); }) </script>
    @endcomponent
</div>
