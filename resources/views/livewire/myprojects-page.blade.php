<div>
    @component('components.layouts.page-header', ['title'=> 'Mes projets'])

        @livewire('forms.myprojectadd_form', [])

    @endcomponent

    <div class="row g-2">
        @foreach($projects as $project)
            <div class="col-md-4 col-lg-4 col-xl-4">
                @livewire('cards.myproject_card_extended', ['project' => $project], key("project_$project->id"))
            </div>
        @endforeach
    </div>


    @component('components.modal', ["id"=>'editProject', 'title' => 'Editer un projet', 'method'=>'update'])
    <form class="row align-items-center" wire:submit="update">
        @include('_form.myproject_form')
    </form>

    <script> window.addEventListener('open-editProject', event => { window.$('#editProject').modal('show'); }) </script>
    <script> window.addEventListener('close-editProject', event => { window.$('#editProject').modal('hide'); }) </script>
    @endcomponent
</div>
