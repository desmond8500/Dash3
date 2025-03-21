<div>
    <button class='btn btn-primary btn-pill' wire:click="dispatch('open-addbadge')" ><i class='ti ti-plus'></i> Badge</button>

    @component('components.modal', ["id"=>'addbadge', 'title' => 'Ajouter un badge', "method"=>"store"])
        <form class="row" wire:submit="store">
            @include('_form.badge_form')

        </form>
        <script> window.addEventListener('open-addbadge', event => { window.$('#addbadge').modal('show'); }) </script>
        <script> window.addEventListener('close-addbadge', event => { window.$('#addbadge').modal('hide'); }) </script>
    @endcomponent



</div>
