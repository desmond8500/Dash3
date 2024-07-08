<div>
    @component('components.layouts.page-header', ['title'=> 'Journaux'])
        @livewire('form.journal-add',['projet_id'=>$projet_id])
    @endcomponent

    <div>sqdfs</div>

    <div class="row g-2">
        <div class="col-md-8">
            <div class="row g-2">
                @forelse ($journaux as $journal)
                    <div class="col-md-6">
                        @component('_card.journal_card',['journal'=>$journal])
                        @endcomponent
                    </div>
                @empty
                    <div class="card mt-2">
                        <i class="ti ti-mood-empty"></i>
                    </div>
                @endforelse
            </div>
        </div>
        <div class="col-md-4">

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
