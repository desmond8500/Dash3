<div>
    @component('components.layouts.page-header', ['title'=>$journal->title, 'breadcrumbs'=>$breadcrumbs])
        <div class="btn-list">
            <a class="btn btn-*primary" target="_blank" href="{{ route('journal_pdf',['journal_id'=>$journal->id]) }}">PDF</a>
            @livewire('form.achat-add',['journal_id' => $journal->id])
        </div>
    @endcomponent

    @push('css')
        <style>
            /* h1, h2, h3, h4{
                background: grey;
                color: white;
                padding: 5px;
                border-radius: 5px;
                font-size: 18px;
            } */
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
        <div class="col-md-8 mb-2">

            <div class="card mb-2">
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
                    <x-markdown>
                        {{ $journal->description }}
                    </x-markdown>
                </div>
            </div>

            <div class="mb-2">
                @livewire('volt.journal.journal_section', ['journal_id' => $journal->id], key($journal->id))
            </div>

            <div class="mb-2">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Devis</div>
                        <div class="card-actions">
                            <div class="dropdown">
                                <button class="btn btn-primary" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                                    @disabled(! $devis_disponibles->count())>
                                    <i class="ti ti-plus"></i> Lier un devis
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    @forelse ($devis_disponibles as $disponible)
                                        <a class="dropdown-item" wire:click="add_devis('{{ $disponible->id }}')">
                                            <span class="fw-bold">{{ $disponible->reference }}</span>
                                            <span class="text-muted ms-1">{{ Str::limit($disponible->description, 40) }}</span>
                                        </a>
                                    @empty
                                        <span class="dropdown-item text-muted">Aucun autre devis sur ce projet</span>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="list-group list-group-flush">
                        @forelse ($devis as $d)
                            <div class="list-group-item" wire:key="devis-{{ $d->id }}">
                                <div class="d-flex align-items-center">
                                    <div class="min-w-0">
                                        <a href="{{ route('invoice', ['invoice_id' => $d->id]) }}" class="fw-bold">
                                            {{ $d->reference }}
                                        </a>
                                        @if ($d->statut)
                                            <span class="badge bg-blue-lt ms-1">{{ $d->statut }}</span>
                                        @endif
                                        <div class="text-muted">{{ $d->description }}</div>
                                    </div>
                                    <div class="ms-auto text-end">
                                        <div class="fw-bold text-nowrap">{{ number_format($d->total(), 0, ',', ' ') }} F</div>
                                        <div class="text-muted" style="font-size: 12px;">{{ $d->rows->count() }} ligne(s)</div>
                                    </div>
                                    <button class="btn btn-icon btn-ghost-danger ms-2" title="Détacher du journal"
                                        wire:click="delete_devis('{{ $d->id }}')"
                                        wire:confirm="Détacher le devis {{ $d->reference }} de ce journal ?">
                                        <i class="ti ti-unlink"></i>
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div class="list-group-item text-muted">Aucun devis rattaché à ce journal.</div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>

        <div class="col-md-4">

            <div class="card mb-2">
                <div class="card-header">
                    <div class="card-title">Intervenants</div>
                    <div class="card-actions">
                        <button class='btn btn-primary' wire:click="$dispatch('open-addTeam')"><i class='ti ti-plus'></i> Intervenant</button>
                    </div>
                </div>
                <div class="card-body">
                    @foreach ($intervenants as $intervenant)
                        <div class="row border-bottom my-1">
                            <div class="col-md">
                                @if ($intervenant->contact_id)
                                    <i class="ti ti-user"></i> {{ $intervenant->contact->firstname }} {{ $intervenant->contact->lastname }}
                                @else
                                    <i class="ti ti-user"></i> {{ $intervenant->team->firstname }} {{ $intervenant->team->lastname }}
                                @endif
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-ghost-danger btn-icon " wire:click="delete_intervenant('{{ $intervenant->id }}')">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>


            <div class="card mb-2">
                <div class="card-header">
                    <div class="card-title">Achats à effectuer</div>
                    <div class="card-actions">

                    </div>
                </div>
                <div class="card-body">
                    <div class="">
                        @foreach ($achats as $achat)
                            <div class="btn btn-outline-primary">
                                <a href="{{ route('achat',['achat_id'=>$achat->id]) }}" target="_blank">{{ $achat->name }}</a>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>

        </div>
    </div>

    @component('components.modal', ["id"=>'editJournal', 'title' => 'Editer un journal', 'method'=>'update_journal'])
        <form class="row" wire:submit="update_journal">
            @include('_form.journal_form')
        </form>
        <script> window.addEventListener('open-editJournal', event => { window.$('#editJournal').modal('show'); }) </script>
        <script> window.addEventListener('close-editJournal', event => { window.$('#editJournal').modal('hide'); }) </script>
    @endcomponent

    @component('components.modal', ["id"=>'addTeam', 'title' => 'Ajouter un intervenant'])
        <form class="row" wire:submit="store_team">
            <div class="col-md-12">
                <div class="fw-bold mb-2">Equipe</div>
                @foreach ($team as $personne)
                    <a class="btn btn-primary mb-1"  wire:click="add_team('{{ $personne->id }}')">
                        <i class="ti ti-user"></i>
                        {{ $personne->firstname }} {{ $personne->lastname }}
                    </a>
                @endforeach

            </div>
            <div class="col-md-12">
                <div class="fw-bold mb-2">Contacts</div>
                @foreach ($contacts as $contact)
                    <a class="btn btn-primary mb-1" wire:click="add_contact('{{ $contact->id }}')">
                        <i class="ti ti-user"></i>
                        {{ $contact->firstname }} {{ $contact->lastname }}
                    </a>
                @endforeach
            </div>

            {{-- @include('_form.document_form') --}}
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                {{-- <button type="submit" class="btn btn-primary">Valider</button> --}}
            </div>
        </form>
        <script> window.addEventListener('open-addTeam', event => { window.$('#addTeam').modal('show'); }) </script>
        <script> window.addEventListener('close-addTeam', event => { window.$('#addTeam').modal('hide'); }) </script>
    @endcomponent

</div>
