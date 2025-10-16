<?php

use Livewire\Volt\Component;

new class extends Component {
    public $project_id;

    function mount($project_id){
        $this->project_id = $project_id;
    }

    public function with()
    {
        return [
            'project' => \App\Models\Myproject::find($this->project_id),
        ];
    }
}; ?>

<div>
    <div class="card">
        <div class="card-header">
            Photos
        </div>
        <div class="card-body">
            <p>Gestion des photos du projet</p>
            <div class="row g-2">
                @foreach($project->photos as $photo)
                    <div class="col-md-4">
                        <div class="card p-2 mb-2">
                            <img src="{{ asset($photo->path) }}" alt="A" class="img-fluid rounded ">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
