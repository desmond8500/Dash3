<div>
    <button class='btn btn-primary' wire:click="add" ><i class='ti ti-plus'></i> Zone</button>

    @component('components.modal', ["id"=>'addZone', 'title' => 'Ajouter une zone', 'refresh'=>true, "method"=>"store"])
        <form class="row" wire:submit="store">
            @include('_form.fiche_zone_form')

        </form>
        <script> window.addEventListener('open-addZone', event => { window.$('#addZone').modal('show'); }) </script>
        <script> window.addEventListener('close-addZone', event => { window.$('#addZone').modal('hide'); }) </script>
    @endcomponent
</div>
