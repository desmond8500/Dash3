<div>
    @component('components.layouts.page-header', ['title'=> 'Mes projets'])

        @livewire('forms.myprojectadd_form', [])

    @endcomponent

    <div class="row">
        @foreach($projects as $project)
            <div class="col-md-4">
                @livewire('cards.myproject_card_extended', ['project' => $project], key($project->id))

            </div>
        @endforeach
    </div>

</div>
