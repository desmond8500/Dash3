<div>
    <button class='btn btn-primary' wire:click="$dispatch('open-addObjet')" >
        <i class='ti ti-plus'></i>
        {{-- Equipement --}}
    </button>

    @component('components.modal', ["id"=>'addObjet', 'title' => 'Ajouter un équipement', 'method'=>'store'])
        <form class="row" wire:submit="store">
            @include('_form.objet_form')
        </form>
        <script> window.addEventListener('open-addObjet', event => { window.$('#addObjet').modal('show'); }) </script>
        <script> window.addEventListener('close-addObjet', event => { window.$('#addObjet').modal('hide'); }) </script>
    @endcomponent
</div>
