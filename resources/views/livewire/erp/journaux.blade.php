<div>
    @component('components.layouts.page-header', ['title'=> 'Journaux'])

        @livewire('form.journal-add')

    @endcomponent

    <div class="row g-2">
        <div class="col-md-8">
            <div class="row g-2">
                @forelse ($journaux as $journal)
                    <div class="col-md-5">
                        <div class="card mt-2 p-2">
                            <div class="d-flex justify-content-between">
                                <div class="fw-bold">
                                    <a href="{{ route('journal',['journal_id'=>$journal->id]) }}">{{ $journal->title }}</a>
                                    <div class="text-muted" style="font-size: 12px">{{ $journal->date }}</div>
                                </div>
                                <div>
                                    <button class="btn btn-primary btn-icon" wire:click="edit('{{ $journal->id }}')">
                                        <i class="ti ti-edit"></i>
                                    </button>
                                </div>
                            </div>
                            <div>{{ nl2br($journal->description) }}</div>
                        </div>
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
        <form class="row" wire:submit="update">

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
