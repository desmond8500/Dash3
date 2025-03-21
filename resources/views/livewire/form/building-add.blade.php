<div>
    <button class='btn btn-primary btn-pill' wire:click="dispatch('open-addBuilding')"><i class='ti ti-plus'></i> Building</button>

    @component('components.modal', ["id"=>'addBuilding', 'title' => 'Ajouter un batiment', "method"=>"store"])
        <form class="row" wire:submit="store">

            @include('_form.building_form')

        </form>

        <script> window.addEventListener('open-addBuilding', event => { window.$('#addBuilding').modal('show'); }) </script>
        <script> window.addEventListener('close-addBuilding', event => { window.$('#addBuilding').modal('hide'); }) </script>
    @endcomponent
</div>
