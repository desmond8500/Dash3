<div>
    <button class='btn btn-primary' wire:click="dispatch('open-addSysteme')"><i class='ti ti-plus'></i> Système</button>

    @component('components.modal', ["id"=>'addSysteme', 'title' => 'Ajouter un système', "method"=>"store"])

        <form class="row" wire:submit="store">
            @include('_form.systeme_form')
        </form>
        <script> window.addEventListener('open-addSysteme', event => { window.$('#addSysteme').modal('show'); }) </script>
        <script> window.addEventListener('close-addSysteme', event => { window.$('#addSysteme').modal('hide'); }) </script>
    @endcomponent
</div>

