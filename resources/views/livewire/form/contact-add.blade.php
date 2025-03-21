<div>
    <button class='btn btn-primary btn-pill' wire:click="dispatch('open-addContact')" ><i class='ti ti-plus'></i> Contact</button>

    @component('components.modal', ["id"=>'addContact', 'title' => 'Ajouter un contact', "method"=>"store"])
        <form class="row" wire:submit="store">
            @include('_form.contact_form')
        </form>
        <script> window.addEventListener('open-addContact', event => { window.$('#addContact').modal('show'); }) </script>
        <script> window.addEventListener('close-addContact', event => { window.$('#addContact').modal('hide'); }) </script>
    @endcomponent
</div>
