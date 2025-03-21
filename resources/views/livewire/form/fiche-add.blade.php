<div>
    <button class='btn btn-primary' wire:click="$dispatch('open-addFiche')" ><i class='ti ti-plus'></i> Fiche</button>

    @component('components.modal', ["id"=>'addFiche', 'title' => 'Ajouter une fiche', 'refresh'=>true, "method"=>"store"])
        <form class="row" wire:submit="store">
            @include('_form.fiche_form')
        </form>
        <script> window.addEventListener('open-addFiche', event => { window.$('#addFiche').modal('show'); }) </script>
        <script> window.addEventListener('close-addFiche', event => { window.$('#addFiche').modal('hide'); }) </script>
    @endcomponent
</div>
