<?php

use Livewire\Volt\Component;
use App\Models\Client;
use function Livewire\Volt\{mount};
use App\Livewire\Forms\clientForm;
use Livewire\WithFileUploads;

new class extends Component {
    public int $client_id;
    public array $resume = [0, 0, 0];
    public string $tab = 'projets';
    public clientForm $clientForm;
    use WithFileUploads;

    public function mount(int $client_id) {
        $this->client_id = $client_id;
        $this->resume = [
            \App\Models\Projet::where('client_id', $client_id)->count(),
            \App\Models\Task::where('client_id', $client_id)->count(),
            \App\Models\Contact::where('client_id', $client_id)->count(),
        ];
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

    function selectTab($tab) {
        $this->dispatch('select-projets_tab', $tab);
        $this->tab = $tab;
    }
}; ?>

<div>
    <div class="card p-2">
        <div class="row g-2">
            <div class="col-12">
                <div class="position-absolut top-0 mb-1">
                    <div class="d-flex justify-content-between align-items-center">
                        <button class="btn btn-icon rounded btn-primary" wire:click="edit('{{ $client->id ?? 1 }}')">
                            <i class="ti ti-edit"></i>
                        </button>
                        <div class="text-warning d-flex align-items-center">
                            <i class="ti ti-star"></i>
                            <i class="ti ti-star"></i>
                            <i class="ti ti-star"></i>
                            <i class="ti ti-star"></i>
                            <i class="ti ti-star"></i>
                        </div>
                        @if ($client->favorite)
                            <button class="btn btn-icon btn-outline-danger" data-bs-toggle="tooltip" title="Supprimer des favoris" wire:click="toggleFavorite('{{ $client->id }}')">
                                <i class="ti ti-heart-filled"></i>
                            </button>
                        @else
                            <button class="btn btn-icon btn-outline-secondary" data-bs-toggle="tooltip" title="Ajouter aux favoris" wire:click="toggleFavorite('{{ $client->id }}')">
                                <i class="ti ti-heart"></i>
                            </button>
                        @endif
                    </div>
                </div>
                <img
                    src="{{ asset($client->avatar ?? 'img/icons/user3.png') }}"
                    alt="img" class="w-100"
                    style="max-height: 150px; object-fit: contain; border-radius: 5px 5px 0 0;">
            </div>

            <div class="col-12">
                <h2 class="text-center mt-1 p-0">{{ $client->name }}</h2>
                <p>{{ $client->description }}</p>
            </div>
            <div class="col-md-12">
                <div class="list-group list-group-horizontal">
                    <div class="list-group-item w-100 text-center cursor-pointer @if($tab === 'projets') bg-blue-lt  @endif" wire:click="selectTab('projets')">
                        <div class="fs-6">
                            {{ $resume[0] }}
                        </div>
                        <div>
                            <i class="ti ti-folder"></i>
                        </div>
                        <div>Projets</div>
                    </div>
                    <div class="list-group-item w-100 text-center cursor-pointer @if($tab === 'taches') bg-blue-lt  @endif" wire:click="selectTab('taches')">
                        <div class="fs-6">
                            {{ $resume[1] }}
                        </div>
                        <div>
                            <i class="ti ti-circle-check"></i>
                        </div>
                        <div>Taches</div>
                    </div>
                    <div class="list-group-item w-100 text-center cursor-pointer @if($tab === 'contacts') bg-blue-lt  @endif" wire:click="selectTab('contacts')">
                        <div class="fs-6">
                            {{ $resume[2] }}
                        </div>
                        <div>
                            <i class="ti ti-users"></i>
                        </div>
                        <div>Contacts</div>
                    </div>
                </div>
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
