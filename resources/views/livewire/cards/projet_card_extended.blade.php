<?php

use Livewire\Volt\Component;
use App\Livewire\Forms\projetForm;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

new class extends Component {
    public $projet_id;
    public projetForm $projetForm;

    protected $listeners = ['close-editProjet'=>'with'];

    function mount($projet_id) {
        $this->projet_id = $projet_id;
    }

    public function with(): array {
        return [
            'projet' => \App\Models\Projet::with('client')->find($this->projet_id),
        ];
    }

    function favorite()
    {
        $this->projetForm->set($this->projet_id);
        $this->projetForm->favorite();

    }

    function edit()
    {
        $this->projetForm->set($this->projet_id);
        $this->dispatch('open-editProjet');
    }

    function update()
    {
        $this->projetForm->update();
        $this->dispatch('close-editProjet');
    }
}; ?>

<div class="card">

    <div class="border rounded p-2">
        <div class="row align-items-center">
            <div class="col-auto">
                <img class="avatar avatar-md" src="{{ asset($projet->client->avatar) }}" alt="A">
            </div>
            <div class="col">
                <div class="text-center">
                    <h3 class="fw-bold" >RESUME DU PROJET</h3>
                    {{-- <div class="fw-bold" style="font-size: clamp(0.8rem, 2vw, 3rem);">RESUME DU PROJET</div> --}}
                </div>
            </div>
            <div class="col-auto">
                <div class="dropdown open">
                    <button class="btn btn-action border dropdown-toggle" type="button" id="triggerId"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="ti ti-dots-vertical"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="triggerId">
                        <button class="dropdown-item" wire:click="edit('{{ $projet->id }}')"><i class="ti ti-edit"></i>
                            Editer</button>
                        <button class="dropdown-item" wire:click="favorite()">
                            @if ($projet->favorite)
                            <span class="text-danger"><i class="ti ti-heart-filled"></i> Favoris</span>
                            @else
                            <span class="text-muted"><i class="ti ti-heart"></i> Favoris</span>
                            @endif
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <ul class="list-group list-group-flush mt-2">
            <li class="py-1 border-bottom d-flex justify-content-between">
                <div class="fw-bold text-primary">CLIENT</div>
                <div class="text-muted">{{ $projet->client->name }}</div>
            </li>
            <li class="py-1 border-bottom d-flex justify-content-between">
                <div class="fw-bold text-primary">PROJET</div>
                <div class="text-muted">{{ $projet->name }}</div>
            </li>
            @if ($projet->start_date)
            <li class="py-1 border-bottom d-flex justify-content-between">
                <div class="fw-bold">DATE DE DEBUT</div>
                <div class="text-muted">{{ $projet->start_date ?? 'NA' }}</div>
            </li>
            @endif
            @if ($projet->end_date)
            <li class="py-1 border-bottom d-flex justify-content-between">
                <div class="fw-bold">DATE DE FIN</div>
                <div class="text-muted">{{ $projet->end_date ?? 'NA' }}</div>
            </li>
            @endif
        </ul>
        <div class="my-2">{!! nl2br($projet->description) !!}</div>

    </div>
</div>
