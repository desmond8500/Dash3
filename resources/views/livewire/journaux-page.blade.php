<div>
    @component('components.layouts.page-header', ['title'=>'Journaux', 'breadcrumbs'=>$breadcrumbs])
        <div class="btn-list">
            @livewire('form.journal-add')
            <button class="btn btn-icon" wire:click='$refresh'><i class="ti ti-reload"></i> </button>
        </div>
    @endcomponent
    <style>
        .timeline-simple{
            color: red;
        }
    </style>

    <div class="row">
        <div class="col-md-5">
            <div class="card" style="height: 75vh">
                <div class="card-header">
                    <div class="card-title">Liste des journaux</div>
                </div>
                <div class="bg-blue-lt card-body card-body-scrollable card-body-scrollable-shadow">
                    <ul class="timeline timeline-simple">
                        @forelse ($journaux->sortByDesc('date') as $journal)
                        <li class="timeline-event">
                            <div class="mb-1">
                                @component('_card.journal_card',['journal'=>$journal]) @endcomponent
                            </div>
                        </li>
                        @empty
                            <div class="card mt-2">
                                <i class="ti ti-mood-empty"></i>
                            </div>
                        @endforelse
                    </ul>
                </div>
                <div class="card-footer">
                    <div>
                        {{ $journaux->links() }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            @if ($selected)
                <div class="card">
                    <div class="card-header">
                        <div>
                            <div class="card-title">{{ $selected->title }}</div>
                            <div class="card-subtitle">{{ $selected->formatDate() }}</div>
                        </div>
                        <div class="card-actions">
                            <div class="dropdown">
                                <button class="btn btn-action border dropdown-toggle" type="button" id="triggerId" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <i class="ti ti-dots-vertical"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="triggerId">
                                    <a class="dropdown-item" wire:click="edit_journal('{{ $selected->id }}')"><i class="ti ti-edit me-2"></i> Editer</a>
                                    <a class="dropdown-item" target="_blank" href="{{ route('journal_pdf',['journal_id'=>$selected->id]) }}"><i class="ti ti-file-type-pdf me-2"></i> PDF</a>
                                    <a class="dropdown-item text-danger" wire:click="delete_journal('{{ $selected->id }}')" wire:confirm='Etes-vous sur de vouloir supprimer ce journal'><i class="ti ti-trash me-2"></i>Supprimer</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @parsedown($selected->description)
                    </div>
                    <div class="card-footer">

                    </div>
                </div>

            @endif
        </div>
    </div>




    {{-- <div class="row g-2">
        <div class="col-md-4">
            @forelse ($journaux->sortByDesc('date') as $journal)
                <div class="mb-1">
                    @component('_card.journal_card',['journal'=>$journal]) @endcomponent

                </div>
            @empty
                <div class="card mt-2">
                    <i class="ti ti-mood-empty"></i>
                </div>
            @endforelse
        </div>
        <div class="col-md-8">

        </div>
        <div class="col-md-12">
            {{ $journaux->links() }}
        </div>
    </div> --}}
{{--
    <div class="row g-2">
        <div class="col-md-12">
            <div class="row row-deck g-2">
                @forelse ($journaux->sortByDesc('date') as $journal)
                    <div class="col-md-4">
                        @component('_card.journal_card',['journal'=>$journal]) @endcomponent
                    </div>
                @empty
                    <div class="card mt-2">
                        <i class="ti ti-mood-empty"></i>
                    </div>
                @endforelse
            </div>
        </div>
        <div class="col-md-12">
            {{ $journaux->links() }}
        </div>
    </div> --}}

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
