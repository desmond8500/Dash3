<?php

use Livewire\Volt\Component;

new class extends Component {
    public $project;
}; ?>

<div>
    <div class="card p-2">
        <div class="row">
            <div class="col-auto">
                <img src="" alt="A" class="avatar avatar-md">
            </div>
            <div class="col">
                <div class="card-title">{{ $project->name }}</div>
                <div class="text-muted">{!! nl2br($project->description) !!}</div>
            </div>
            <div class="col-auto">
              <button class="btn btn-outline-primary btn-icon" wire:click="edit('{{ $project->id }}')">
                <i class="ti ti-edit"></i>
              </button>
              <button class="btn btn-outline-danger btn-icon" wire:click="edit('{{ $project->id }}')">
                <i class="ti ti-trash"></i>
              </button>
          </div>
        </div>
    </div>
</div>
