<div>
    <div class="d-flex justify-content-between mb-1">
        <h2>Journal d'activité</h2>
        <div>
            <input type="text" class="form-control" wire:model.live="search" placeholder="Rechercher" >
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
                @component('_card.journal_card',['journal'=>$journal,])
                @endcomponent
            </div>
        @empty
            <div class="card mt-2">
                <i class="ti ti-mood-empty"></i>
            </div>
        @endforelse
        <div>
            {{-- {{ $journaux->links() }} --}}
            {{-- @dump($projets) --}}
        </div>
    </div>

    @component('components.modal', ["id"=>'editJournal', 'title'=> 'Editer un journal', "method"=>"update_journal"])
        <form class="row" wire:submit="update_journal">
            @include('_form.journal_form',['projets'=>$projets])
        </form>
        <script> window.addEventListener('open-editJournal', event => { window.$('#editJournal').modal('show'); }) </script>
        <script> window.addEventListener('close-editJournal', event => { window.$('#editJournal').modal('hide'); }) </script>
    @endcomponent

</div>
