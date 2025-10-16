<div>
    @component('components.layouts.page-header', ['title'=> $project->name, 'breadcrumbs' => $breadcrumbs])


    @endcomponent


    <div class="row g-2">
        <div class="col-md-4">
            <div class="card p-2 mb-2">
                <img src="{{ asset($project->logo) }}" alt="A" class="img-fluid rounded ">
            </div>

            <div class="card mb-2 p-2">
                {{ nl2br($project->description) }}
            </div>


        </div>
        <div class="col-md-8">
            <div class="mb-2">
                @livewire('myproject_photos_extended', ['project_id' => $project_id], key("$project->id.projectphotos"))
            </div>
            <ul>
                <li>Documents</li>
            </ul>

        </div>
    </div>

</div>
