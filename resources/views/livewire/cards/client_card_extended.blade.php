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
                <div class="row g-2">
                    {{-- Projets --}}
                    <div class="col-4">
                        <div class="card card-sm h-100 text-center cursor-pointer transition-base
                                @if($tab === 'projets') bg-blue-lt border-primary @endif" wire:click="selectTab('projets')">
                            <div class="card-body p-2">
                                <div class="fs-2 fw-bold lh-1">
                                    {{ $resume[0] }}
                                </div>

                                <div class="my-1">
                                    <i class="ti ti-folder fs-2"></i>
                                </div>

                                <div class="small fw-medium">Projets</div>
                            </div>
                        </div>
                    </div>

                    {{-- Tâches --}}
                    <div class="col-4">
                        <div class="card card-sm h-100 text-center cursor-pointer transition-base
                                @if($tab === 'taches') bg-blue-lt border-primary @endif" wire:click="selectTab('taches')">
                            <div class="card-body p-2">
                                <div class="fs-2 fw-bold lh-1">
                                    {{ $resume[1] }}
                                </div>

                                <div class="my-1">
                                    <i class="ti ti-circle-check fs-2"></i>
                                </div>

                                <div class="small fw-medium">Tâches</div>
                            </div>
                        </div>
                    </div>

                    {{-- Contacts --}}
                    <div class="col-4">
                        <div class="card card-sm h-100 text-center cursor-pointer transition-base
                                @if($tab === 'contacts') bg-blue-lt border-primary @endif" wire:click="selectTab('contacts')">
                            <div class="card-body p-2">
                                <div class="fs-2 fw-bold lh-1">
                                    {{ $resume[2] }}
                                </div>

                                <div class="my-1">
                                    <i class="ti ti-users fs-2"></i>
                                </div>

                                <div class="small fw-medium">Contacts</div>
                            </div>
                        </div>
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
