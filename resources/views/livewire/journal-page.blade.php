<div>
    @component('components.layouts.page-header', ['title'=>'Journal', 'breadcrumbs'=>$breadcrumbs])
        <div class="btn-list">
            <a class="btn btn-*primary" target="_blank" href="{{ route('journal_pdf',['journal_id'=>$journal->id]) }}">PDF</a>
            @livewire('form.task-add', ['journal_id' => $journal->id])
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
        <div class="col-md-12">
            <div class="status status-blue">
                <div class="d-flex">
                    <a class="" data-bs-toggle="tooltip" data-bs-placement="top" href="{{ route('projets', ['client_id'=>$journal->projet->client->id]) }}" title="Client">{{ $journal->projet->client->name }}</a>
                    <span class="mx-1">/</span>
                    <a class="" data-bs-toggle="tooltip" data-bs-placement="top" href="{{ route('projet', ['projet_id'=>$journal->projet->id]) }}" title="Projet">{{ $journal->projet->name }}</a>
                    <span class="mx-1">/</span>
                    <a class="" data-bs-toggle="tooltip" data-bs-placement="top" href="{{ route('journal', ['journal_id'=>$journal->id]) }}" title="Journal">Journal</a>
                </div>
            </div>
        </div>

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

            <div class="mt-2">
                @livewire('erp.tasklist', ['journal_id' => $journal->id, 'paginate'=>3])
            </div>

        </div>

        <div class="col-md-4">
            <div class="card mb-2">
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
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-addTeam', event => { $('#addTeam').modal('show'); }) </script>
        <script> window.addEventListener('close-addTeam', event => { $('#addTeam').modal('hide'); }) </script>
    @endcomponent

</div>
