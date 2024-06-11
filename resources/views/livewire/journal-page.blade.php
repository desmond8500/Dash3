<div>
    @component('components.layouts.page-header', ['title'=>'Journal', 'breadcrumbs'=>$breadcrumbs])
    <div class="btn-list">
        {{-- @livewire('form.task-add', ['projet_id' => $projet_id])
        @livewire('form.journal-add', ['projet_id' => $projet_id]) --}}
    </div>
    @endcomponent

    <div class="row g-2">
        <div class="col-md-4">

            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{ $journal->title }}</div>
                    <div class="card-actions">
                        <button class="btn btn-primary btn-icon" wire:click="edit_journal('{{ $journal->id }}')">
                            <i class="ti ti-edit"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    {!! nl2br($journal->description) !!}
                </div>
            </div>

        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Rapports</div>
                    <div class="card-actions">

                    </div>
                </div>
                <div class="card-body">

                </div>
                <div class="card-footer">

                </div>
            </div>
        </div>
    </div>

    @component('components.modal', ["id"=>'editJournal', 'title' => 'Editer un journal'])
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
