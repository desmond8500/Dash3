<div>
    @component('components.layouts.page-header', ['title'=>'Journal', 'breadcrumbs'=>$breadcrumbs])
        <div class="btn-list">
            <a class="btn btn-*primary" target="_blank" href="{{ route('journal_pdf',['journal_id'=>$journal->id]) }}">PDF</a>
        </div>
    @endcomponent

    @push('css')
        <style>
            h1, h2, h3, h4{
                background: grey;
                color: white;
                padding: 5px;
                border-radius: 5px;
                font-size: 18px;
            }
            table {
                width: 100%;
                border-collapse: collapse;
            }

            thead {
                background-color: #D1D2D4;
                padding: 3px;
                padding-right: 10px;
            }

            th {
                padding: 4px;
            }

        </style>
    @endpush

    <div class="row g-2">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <div style="font-size: 12px;" class="text-primary">{{ $journal->formatDate() }}</div>
                        <div>{{ $journal->title }}</div>
                    </div>
                    <div class="card-actions">
                        <button class="btn btn-primary btn-icon" wire:click="edit_journal('{{ $journal->id }}')">
                            <i class="ti ti-edit"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @parsedown($journal->description)
                </div>
            </div>

        </div>
        <div class="col-md-4">
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
