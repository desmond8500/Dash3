<div>
    @component('components.layouts.page-header', ['title'=> 'Mon projet'])


    @endcomponent


    <div class="row g-2">
        <div class="col-md-4">
            <div class="card p-2">
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-between gap-1">
                      <button class="btn btn-outline-primary btn-icon" wire:click="edit('{{ $project->id }}')">
                        <i class="ti ti-edit"></i>
                      </button>
                      <button class="btn btn-outline-danger btn-icon" wire:click="edit('{{ $project->id }}')">
                        <i class="ti ti-trash"></i>
                      </button>
                    </div>
                    <div class="col-12 justify-content-center d-flex mb-2">
                        <img src="{{ asset($project->logo) }}" alt="A" class="img-fluid rounded ">
                    </div>
                    <div class="col-12">
                        <div class="fw-bold">Titre</div>
                        <div class="text-muted">Description</div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-6">

        </div>
    </div>

</div>
