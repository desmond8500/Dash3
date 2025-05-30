<div>
    <button class='btn btn-primary' wire:click="$dispatch('open-addCV')" ><i class='ti ti-plus'></i> CV</button>

    @component('components.modal', ["id"=>'addCV', 'title' => 'Ajouter un CV', 'method'=>'store'])
        <form class="row" wire:submit="store">
            @include('_form.cv_form')
        </form>
        <script> window.addEventListener('open-addCV', event => { window.$('#addCV').modal('show'); }) </script>
        <script> window.addEventListener('close-addCV', event => { window.$('#addCV').modal('hide'); }) </script>
    @endcomponent
</div>
