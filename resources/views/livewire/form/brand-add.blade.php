<div>
    <button class='btn btn-primary' ><i class='ti ti-plus'></i> Marque</button>
    
    @component('components.modal', ["id"=>'addBrand', 'title' => 'Ajourter une marque'])
        <form class="row" wire:submit="store">
    
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-addBrand', event => { $('#addBrand').modal('show'); }) </script>
        <script> window.addEventListener('close-addBrand', event => { $('#addBrand').modal('hide'); }) </script>
    @endcomponent
</div>
