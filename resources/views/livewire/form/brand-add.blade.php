<div>
    <button class='btn btn-primary' wire:click="$dispatch('open-addBrand')">
        <i class='ti ti-plus'></i>
        M<div class="d-none d-sm-block">arque</div>
    </button>

    @component('components.modal', ["id"=>'addBrand', 'title' => 'Ajourter une marque', "method"=>"store"])
        <form class="row" wire:submit="store">
            @include('_form.article_brand_form')

        </form>
        <script> window.addEventListener('open-addBrand', event => { window.$('#addBrand').modal('show'); }) </script>
        <script> window.addEventListener('close-addBrand', event => { window.$('#addBrand').modal('hide'); }) </script>
    @endcomponent
</div>
