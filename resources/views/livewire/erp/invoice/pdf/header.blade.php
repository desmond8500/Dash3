<?php

use Livewire\Volt\Component;

new class extends Component {
    public $data;
    public $logo;
    public $document_name;
    public $date;
    public $client;

    function mount($data)
    {
        $this->logo = $data['logo'] ?? null;
        $this->document_name = $data['type'] ?? null;
        $this->date = $data['date'] ?? null;
        $this->client = $data['proposal']->invoice->projet->client ?? null;
        $this->projet = $data['proposal']->invoice->projet ?? null;

    }
}; ?>

<div class="border rounded p-1 mb-2 bg-white">
    <div class="row">
        <div class="col-auto">
            <img src="{{ $logo ?? '' }}" alt="" class="avatar avatar-xl rounded p-1" />
        </div>
        <div class="col">
            <div>
                <b>Client :</b> {{ $client->name ?? '' }}
            </div>
            <div>
                <b>Projet :</b> {{ $projet->name ?? '' }}
            </div>
            <div>
                <b>Debut :</b>
            </div>
            <div>
                <b>Fin :</b>
            </div>
        </div>
        <div class="col-auto">
            <h1 class="text-uppercase fw-bold">{{ $document_name ?? 'Document' }}</h1>
            <div class="text-muted"> {{ $date->format('d/m/Y') }}</div>
        </div>
    </div>
</div>
