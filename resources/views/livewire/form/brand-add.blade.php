<div>
    <button class='btn btn-primary' wire:click="$dispatch('open-addBrand')"><i class='ti ti-plus'></i> Marque</button>

    @component('components.modal', ["id"=>'addBrand', 'title' => 'Ajourter une marque'])
        <form class="row" wire:submit="store">
            @include('_form.article_brand_form')
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-addBrand', event => { window.$('#addBrand').modal('show'); }) </script>
        <script> window.addEventListener('close-addBrand', event => { window.$('#addBrand').modal('hide'); }) </script>
    @endcomponent
</div>
