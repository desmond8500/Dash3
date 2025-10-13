<?php

use Livewire\Volt\Component;
use App\Livewire\Forms\MyprojectForm;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

new class extends Component {
    use WithFileUploads;
    use WithPagination;

    public $project;
    public MyprojectForm $project_form;

    function edit_project(){
        $this->dispatch('editProject', $this->project->id);
    }
    function update(){
        $this->dispatch('updateProject');
    }
}; ?>

<div>
    <div class="card p-2">
        <div class="row">
            <div class="col-auto">
                <img src="{{ asset($project->logo) }}" alt="A" class="avatar avatar-xl">
            </div>
            <a class="col" href="{{ route('myproject',['project_id'=> $project->id]) }}">
                <div class="card-title">{{ $project->name }}</div>
                <div class="text-muted">{!! nl2br($project->description) !!}</div>
            </a>
            <div class="col-auto">
              <div class="dropdown open">
                  <button class="btn btn-action" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                      <i class="ti ti-chevron-down"></i>
                  </button>
                  <div class="dropdown-menu" aria-labelledby="triggerId">
                      <a class="dropdown-item" wire:click="edit_project()"> <i class="ti ti-edit"></i> Editer</a>
                      <a class="dropdown-item text-danger" wire:click="delete_project()"> <i class="ti ti-trash"></i> Supprimer</a>
                  </div>
              </div>
            </div>
        </div>
    </div>



</div>
