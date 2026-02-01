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
                    <div class="card-actions">
                        <div class="input-icon">
                            <input type="text" class="form-control form-control-rounded" wire:model.live="search" placeholder="Chercher ">
                            <span class="input-icon-addon">
                                <i class="ti ti-search"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="bg-blue-lt p-2 card-body-scrollable card-body-scrollable-shadow">
                    <ul class="timeline timeline-simple">
                        @forelse ($journaux->sortByDesc('date') as $journal)
                        <li class="timeline-event" wire:click="select({{ $journal->id }})" style="cursor: pointer; {{ $selected && $selected->id === $journal->id ? 'background-color: #e7f1ff;' : '' }}">
                            <div class="mb-0">
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
                    {{ $journaux->links() }}
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
                        <x-markdown>
                         {{ $selected->description }}
                        </x-markdown>
                    </div>
                    <div class="card-footer">

                    </div>
                </div>

            @endif
        </div>
    </div>

    @component('components.modal', ["id"=>'editJournal', 'title'=> 'Editer un journal', "method"=>'update_journal'])
        <form class="row" wire:submit="update_journal">
            @include('_form.journal_form')
        </form>
        <script> window.addEventListener('open-editJournal', event => { window.$('#editJournal').modal('show'); }) </script>
        <script> window.addEventListener('close-editJournal', event => { window.$('#editJournal').modal('hide'); }) </script>
    @endcomponent
</div>
