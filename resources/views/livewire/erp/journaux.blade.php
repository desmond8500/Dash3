<div>
    <div class="d-flex justify-content-between mb-1">
        <h2>Journal d'activité</h2>
        <div class="input-group">
            <input type="text" class="form-control" wire:model.defer="search" placeholder="Rechercher" wire:keydown.enter='getArticles'>
            <button class="btn btn-primary btn-icon" wire:click="getArticles">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path stroke="none" d="M0 0h24v24H0z" fill="none"></path> <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path> <path d="M21 21l-6 -6"></path> </svg>
            </button>
            @if ($search)
                <button class="btn btn-secondary btn-icon" wire:click="resetSearch">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path stroke="none" d="M0 0h24v24H0z" fill="none"></path> <path d="M18 6l-12 12"></path> <path d="M6 6l12 12"></path> </svg>
                </button>
            @endif
        </div>
        @component("components.off-canvas", ['button'=>'Todo'])
            <ul>
                <li>Editer une entrée de journal</li>
                <li>Consulter et remplir un journal</li>
            </ul>
        @endcomponent
    </div>
    <div class="row g-2">
        @forelse ($journaux as $journal)
            <div class="col-md-4">
                @component('_card.journal_card',['journal'=>$journal])
                @endcomponent
            </div>
        @empty
            <div class="card mt-2">
                <i class="ti ti-mood-empty"></i>
            </div>
        @endforelse
        <div>
            {{-- {{ $journaux->links() }} --}}
        </div>
    </div>

    @component('components.modal', ["id"=>'editJournal', 'title'=> 'Editer un journal'])
        <form class="row" wire:submit="update_journal">

            @include('_form.journal_form')

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-editJournal', event => { $('#editJournal').modal('show'); }) </script>
        <script> window.addEventListener('close-editJournal', event => { $('#editJournal').modal('hide'); }) </script>
    @endcomponent

</div>
