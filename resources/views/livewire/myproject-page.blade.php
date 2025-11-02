<div>
    @component('components.layouts.page-header', ['title'=> $project->name, 'breadcrumbs' => $breadcrumbs])
        <button class="btn btn-primary" wire:click='edit_project'>Editer</button>
    @endcomponent


    <div class="row g-2">
        <div class="col-md-3">
            <div class="card p-2 mb-2">
                <img src="{{ asset($project->logo) }}" alt="A" class="img-fluid rounded ">
            </div>

            <div class="card mb-2 p-2">
                {{ nl2br($project->description) }}
            </div>
        </div>
        <div class="col-md-9">
            <div class="mb-2">
                @livewire('myproject_photos_extended', ['project_id' => $project_id], key("$project->id.projectphotos"))
            </div>
        </div>
    </div>
    @component('components.modal', ["id"=>'editProject', 'title' => 'Editer un projet', 'method'=>'update'])
    <form class="row align-items-center" wire:submit="update">
        @include('_form.myproject_form')
    </form>

    <script> window.addEventListener('open-editProject', event => { window.$('#editProject').modal('show'); }) </script>
    <script> window.addEventListener('close-editProject', event => { window.$('#editProject').modal('hide'); }) </script>
    @endcomponent
</div>
