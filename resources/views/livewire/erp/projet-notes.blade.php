<div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">Notes</div>
            <div class="card-actions">
                <button class="btn btn-primary btn-pill" wire:click="$dispatch('open-addProjetNote')">
                    <i class="ti ti-plus"></i> Note
                </button>
            </div>
        </div>
        <div class="card-body row g-2">
            @foreach ($notes as $note)
                <div class="col-md-4">
                    @include('_card.projet_note_card')
                </div>
            @endforeach
        </div>

    </div>

    @component('components.modal', ["id"=>'addProjetNote', 'title' => 'Ajouter une note', 'method'=>'store'])
        <form class="row" wire:submit="store">
            @include('_form.projet_note_form')
        </form>
        <script> window.addEventListener('open-addProjetNote', event => { window.$('#addProjetNote').modal('show'); }) </script>
        <script> window.addEventListener('close-addProjetNote', event => { window.$('#addProjetNote').modal('hide'); }) </script>
    @endcomponent

    @component('components.modal', ["id"=>'editProjetNote', 'title' => 'Ajouter une note', 'method'=>'update'])
        <form class="row" wire:submit="update">
            @include('_form.projet_note_form')
        </form>
        <script> window.addEventListener('open-editProjetNote', event => { window.$('#editProjetNote').modal('show'); }) </script>
        <script> window.addEventListener('close-editProjetNote', event => { window.$('#editProjetNote').modal('hide'); }) </script>
    @endcomponent
</div>
