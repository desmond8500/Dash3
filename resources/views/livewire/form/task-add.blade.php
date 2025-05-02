<div>
    <button class='btn btn-primary' wire:click="$dispatch('open-addTask')" data-bs-toggle="tooltip" title="Ajouter une tache">
        <i class='ti ti-plus'></i> Tache
    </button>

    @component('components.modal', ["id"=>'addTask', 'title' => 'Ajouter une tache', "method"=>"store"])
        <form class="row" wire:submit="store">
            @include('_form.tache_form')
        </form>
        <script> window.addEventListener('open-addTask', event => { window.$('#addTask').modal('show'); }) </script>
        <script> window.addEventListener('close-addTask', event => { window.$('#addTask').modal('hide'); }) </script>
    @endcomponent
</div>
