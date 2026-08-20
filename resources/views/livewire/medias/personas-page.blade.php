<div>
    @component('components.layouts.page-header', ['title'=> 'Personas', 'breadcrumbs'=>$breadcrumbs])
        <button class='btn btn-primary' wire:click="$dispatch('open-addPersona')"><i class='ti ti-plus'></i> Persona</button>
    @endcomponent

    <div class="row row-deck g-2">
        <div class="col-md-12">

        </div>

        @foreach ($personas as $persona)
            <div class="col-md-2">
                @include("_card.persona_card",['persona'=>$persona])
            </div>
        @endforeach


        @component('components.modal', ["id"=>'addPersona', 'title' => 'Ajouter un persona', 'method'=>'store'])
            <form class="row" wire:submit="store">
                @include('_form.persona_form')
            </form>
            <script> window.addEventListener('open-addPersona', event => { window.$('#addPersona').modal('show'); }) </script>
            <script> window.addEventListener('close-addPersona', event => { window.$('#addPersona').modal('hide'); }) </script>
        @endcomponent
        @component('components.modal', ["id"=>'editPersona', 'title' => 'Modifier un persona', 'method'=>'update'])
            <form class="row" wire:submit="update">
                @include('_form.persona_form')
            </form>
            <script> window.addEventListener('open-editPersona', event => { window.$('#editPersona').modal('show'); }) </script>
            <script> window.addEventListener('close-editPersona', event => { window.$('#editPersona').modal('hide'); }) </script>
        @endcomponent
    </div>
</div>

