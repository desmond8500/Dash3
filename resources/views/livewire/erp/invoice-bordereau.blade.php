<div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">Bordereaux</div>
            <div class="card-actions">
                <button class="btn btn-primary" wire:click="$dispatch('open-addBL')" data-bs-toggle="tooltip" title="Ajouter un bordereau">
                    <i class="ti ti-plus"></i> BL
                </button>
            </div>
        </div>
        <div class="p-2">
            @foreach ($bls as $bl)
                <div class="card rounded mb-1 p-1">
                    <div class="row">
                        <a class="col" href="{{ route('bl_pdf', ['invoice_bl_id'=>$bl->id, ]) }}" target="_blank">
                            <div>{{ ucfirst($bl->name) }}</div>
                            <div style="font-size: 10px">{{ ucfirst($bl->type) }}</div>
                        </a>
                        <div class="col-auto">
                            <button class="btn btn-primary btn-icon" wire:click="edit('{{ $bl->id }}')">
                                <i class="ti ti-edit"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
        <div class="card-footer">

        </div>
    </div>

    @component('components.modal', ["id"=>'addBL', 'title' => 'Ajouter un bordereau'])
        <form class="row" wire:submit="store">
            @include('_form.bl_form')
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-addBL', event => { window.$('#addBL').modal('show'); }) </script>
        <script> window.addEventListener('close-addBL', event => { window.$('#addBL').modal('hide'); }) </script>
    @endcomponent

    @component('components.modal', ["id"=>'editBL', 'title' => 'Ajouter un bordereau'])
        <form class="row" wire:submit="update">
            @include('_form.bl_form')
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-editBL', event => { window.$('#editBL').modal('show'); }) </script>
        <script> window.addEventListener('close-editBL', event => { window.$('#editBL').modal('hide'); }) </script>
    @endcomponent
</div>
