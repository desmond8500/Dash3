<div>
    @component('components.layouts.page-header', ['title'=> $project->name, 'breadcrumbs' => $breadcrumbs])
        <div class="btn-list">
            <button class="btn" wire:click='edit_project'><i class="ti ti-edit"></i> Editer</button>
            <button class="btn btn-primary" wire:click="add_files('photos')"><i class="ti ti-camera"></i> Photos</button>
        </div>
    @endcomponent

    @php
        $previsionsTotal = $previsions->sum(fn ($t) => $t->total());
        $depensesTotal = $depenses->sum(fn ($t) => $t->total());
        $tasksDone = $project->tasks->where('statut_id', '>=', 4)->count();
    @endphp

    <div class="row g-2">
        {{-- Résumé --}}
        <div class="col-md-3">
            <div class="card mb-2">
                @if ($project->logo)
                    <img src="{{ asset($project->logo) }}" alt="" class="card-img-top">
                @endif
                <div class="card-body">
                    <h3 class="card-title mb-1">{{ $project->name }}</h3>
                    @if ($project->description)
                        <div class="text-muted" style="white-space: pre-line;">{{ $project->description }}</div>
                    @endif
                </div>
                <div class="card-footer">
                    <div class="row g-2 text-center">
                        <div class="col-6">
                            <div class="h3 m-0">{{ $project->photos->count() }}</div>
                            <div class="text-muted small">Images</div>
                        </div>
                        <div class="col-6">
                            <div class="h3 m-0">{{ $project->files->count() }}</div>
                            <div class="text-muted small">Documents</div>
                        </div>
                        <div class="col-6">
                            <div class="h3 m-0">{{ $project->links->count() }}</div>
                            <div class="text-muted small">Liens</div>
                        </div>
                        <div class="col-6">
                            <div class="h3 m-0">{{ $tasksDone }}/{{ $project->tasks->count() }}</div>
                            <div class="text-muted small">Tâches</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Budget en bref --}}
            <div class="card">
                <div class="card-header"><div class="card-title"><i class="ti ti-coins text-primary"></i> Budget</div></div>
                <div class="card-body">
                    <div class="d-flex mb-1">
                        <span class="text-muted">Prévisionnel</span>
                        <span class="ms-auto fw-bold">{{ number_format($previsionsTotal, 0, ',', ' ') }} F</span>
                    </div>
                    <div class="d-flex mb-1">
                        <span class="text-muted">Dépensé</span>
                        <span class="ms-auto fw-bold text-red">{{ number_format($depensesTotal, 0, ',', ' ') }} F</span>
                    </div>
                    <div class="d-flex">
                        <span class="text-muted">Reste à engager</span>
                        <span class="ms-auto fw-bold text-green">{{ number_format(max(0, $previsionsTotal - $depensesTotal), 0, ',', ' ') }} F</span>
                    </div>
                    @if ($previsionsTotal > 0)
                        <div class="progress progress-sm mt-2">
                            <div class="progress-bar {{ $depensesTotal > $previsionsTotal ? 'bg-red' : 'bg-primary' }}"
                                style="width: {{ min(100, round($depensesTotal / $previsionsTotal * 100)) }}%"></div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Onglets --}}
        <div class="col-md-9">
            <nav class="nav nav-segmented w-100 mb-2 border" role="tablist">
                @foreach ([
                    'medias' => ['Images', 'ti-photo'],
                    'documents' => ['Documents', 'ti-file'],
                    'liens' => ['Liens', 'ti-link'],
                    'notes' => ['Notes', 'ti-notes'],
                    'taches' => ['Tâches', 'ti-checkbox'],
                    'budget' => ['Budget', 'ti-coins'],
                ] as $key => $info)
                    <button type="button" class="nav-link {{ $tab === $key ? 'active' : '' }}" role="tab"
                        aria-selected="{{ $tab === $key ? 'true' : 'false' }}" wire:click="$set('tab','{{ $key }}')">
                        <i class="ti {{ $info[1] }}"></i> {{ $info[0] }}
                    </button>
                @endforeach
            </nav>

            {{-- Images --}}
            @if ($tab === 'medias')
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Images</div>
                        <div class="card-actions">
                            <button class="btn btn-primary" wire:click="add_files('photos')"><i class="ti ti-plus"></i> Images</button>
                        </div>
                    </div>
                    <div class="p-2">
                        @if ($project->photos->count())
                            <div class="row g-2">
                                @foreach ($project->photos as $photo)
                                    <div class="col-md-3 col-6" wire:key="photo-{{ $photo->id }}">
                                        <div class="position-relative">
                                            <a href="{{ asset($photo->photo_path) }}" data-lightbox="myproject">
                                                <img src="{{ asset($photo->photo_path) }}" alt="" class="rounded w-100" style="height: 130px; object-fit: cover;">
                                            </a>
                                            <button class="btn btn-sm btn-icon position-absolute" style="top: 4px; right: 4px;"
                                                wire:click="delete_photo('{{ $photo->id }}')" wire:confirm="Supprimer cette image ?">
                                                <i class="ti ti-x"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-muted">Aucune image.</div>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Documents --}}
            @if ($tab === 'documents')
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Documents</div>
                        <div class="card-actions">
                            <button class="btn btn-primary" wire:click="add_files('fichiers')"><i class="ti ti-plus"></i> Documents</button>
                        </div>
                    </div>
                    <div class="list-group list-group-flush">
                        @forelse ($project->files as $file)
                            <div class="list-group-item d-flex align-items-center" wire:key="file-{{ $file->id }}">
                                <i class="ti ti-file me-2"></i>
                                <a href="{{ asset($file->file_path) }}" target="_blank" class="text-reset text-truncate">
                                    {{ $file->description ?: basename($file->file_path) }}
                                </a>
                                <button class="btn btn-icon btn-ghost-danger ms-auto" wire:click="delete_file('{{ $file->id }}')"
                                    wire:confirm="Supprimer ce document ?"><i class="ti ti-trash"></i></button>
                            </div>
                        @empty
                            <div class="list-group-item text-muted">Aucun document.</div>
                        @endforelse
                    </div>
                </div>
            @endif

            {{-- Liens de recherche --}}
            @if ($tab === 'liens')
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Liens de recherche</div>
                        <div class="card-actions">
                            <button class="btn btn-primary" wire:click="add_link"><i class="ti ti-plus"></i> Lien</button>
                        </div>
                    </div>
                    <div class="list-group list-group-flush">
                        @forelse ($project->links as $link)
                            <div class="list-group-item" wire:key="link-{{ $link->id }}">
                                <div class="d-flex align-items-center">
                                    <div class="min-w-0">
                                        <a href="{{ $link->link }}" target="_blank" rel="noopener" class="fw-bold text-truncate d-block">
                                            <i class="ti ti-link me-1"></i>{{ $link->name }}
                                        </a>
                                        <div class="text-muted small text-truncate">{{ $link->link }}</div>
                                        @if ($link->description)
                                            <div class="text-muted small" style="white-space: pre-line;">{{ $link->description }}</div>
                                        @endif
                                    </div>
                                    <div class="ms-auto btn-list flex-nowrap">
                                        <button class="btn btn-icon" wire:click="edit_link('{{ $link->id }}')"><i class="ti ti-edit"></i></button>
                                        <button class="btn btn-icon btn-ghost-danger" wire:click="delete_link('{{ $link->id }}')"
                                            wire:confirm="Supprimer le lien « {{ $link->name }} » ?"><i class="ti ti-trash"></i></button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="list-group-item text-muted">Aucun lien.</div>
                        @endforelse
                    </div>
                </div>
            @endif

            {{-- Notes --}}
            @if ($tab === 'notes')
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Notes</div>
                        <div class="card-actions">
                            <button class="btn btn-primary" wire:click="add_note"><i class="ti ti-plus"></i> Note</button>
                        </div>
                    </div>
                    <div class="p-2">
                        @forelse ($project->notes as $note)
                            <div class="card border mb-2 p-2" wire:key="note-{{ $note->id }}">
                                <div class="d-flex align-items-start">
                                    <div class="fw-bold">{{ $note->title }}</div>
                                    <div class="ms-auto btn-list flex-nowrap">
                                        <button class="btn btn-sm btn-icon" wire:click="edit_note('{{ $note->id }}')"><i class="ti ti-edit"></i></button>
                                        <button class="btn btn-sm btn-icon btn-ghost-danger" wire:click="delete_note('{{ $note->id }}')"
                                            wire:confirm="Supprimer cette note ?"><i class="ti ti-trash"></i></button>
                                    </div>
                                </div>
                                <x-markdown>{{ $note->content }}</x-markdown>
                            </div>
                        @empty
                            <div class="text-muted">Aucune note.</div>
                        @endforelse
                    </div>
                </div>
            @endif

            {{-- Tâches --}}
            @if ($tab === 'taches')
                <div class="card">
                    <div class="card-header"><div class="card-title">Tâches</div></div>
                    <div class="p-2">
                        <form class="d-flex gap-2 mb-2" wire:submit="store_task">
                            <input type="text" class="form-control" wire:model="task_name" placeholder="Ajouter une tâche…">
                            <button class="btn btn-primary" type="submit"><i class="ti ti-plus"></i></button>
                        </form>
                        @error('task_name') <div class="text-danger small mb-2">{{ $message }}</div> @enderror

                        <div class="list-group list-group-flush">
                            @forelse ($project->tasks as $task)
                                <div class="list-group-item d-flex align-items-center px-0" wire:key="task-{{ $task->id }}">
                                    <button class="btn btn-sm btn-icon btn-ghost-secondary" wire:click="toggle_task('{{ $task->id }}')">
                                        <i class="ti {{ $task->statut_id >= 4 ? 'ti-checkbox text-success' : 'ti-square' }}"></i>
                                    </button>
                                    <span @class(['ms-1', 'text-decoration-line-through text-muted' => $task->statut_id >= 4])>{{ $task->name }}</span>
                                    <button class="btn btn-sm btn-icon btn-ghost-danger ms-auto" wire:click="delete_task('{{ $task->id }}')"
                                        wire:confirm="Supprimer la tâche « {{ $task->name }} » ?"><i class="ti ti-trash"></i></button>
                                </div>
                            @empty
                                <div class="text-muted">Aucune tâche.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            @endif

            {{-- Budget --}}
            @if ($tab === 'budget')
                <div class="row g-2">
                    @foreach ([
                        ['prevision', 'Achats prévisionnels', $previsions, $previsionsTotal, 'ti-shopping-cart'],
                        ['depense', 'Dépenses', $depenses, $depensesTotal, 'ti-cash'],
                    ] as [$type, $titre, $lignes, $somme, $icone])
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header">
                                    <div class="card-title"><i class="ti {{ $icone }}"></i> {{ $titre }}</div>
                                    <div class="card-actions">
                                        <button class="btn btn-sm btn-primary" wire:click="add_transaction('{{ $type }}')"><i class="ti ti-plus"></i></button>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-vcenter card-table">
                                        <thead>
                                            <tr>
                                                <th>Libellé</th>
                                                <th class="text-center">Qté</th>
                                                <th class="text-end">Montant</th>
                                                <th class="w-1"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($lignes as $ligne)
                                                <tr wire:key="transaction-{{ $ligne->id }}">
                                                    <td>
                                                        <div class="fw-bold">{{ $ligne->name }}</div>
                                                        @if ($ligne->transaction_date)
                                                            <div class="text-muted small">{{ $ligne->transaction_date->format('d/m/Y') }}</div>
                                                        @endif
                                                        @if ($ligne->description)
                                                            <div class="text-muted small" style="white-space: pre-line;">{{ $ligne->description }}</div>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">{{ $ligne->quantity }}</td>
                                                    <td class="text-end text-nowrap">{{ number_format($ligne->total(), 0, ',', ' ') }} F</td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn btn-action" type="button" data-bs-toggle="dropdown" aria-label="Actions">
                                                                <i class="ti ti-dots-vertical"></i>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                @if ($type === 'prevision')
                                                                    <a class="dropdown-item" wire:click="mark_spent('{{ $ligne->id }}')">
                                                                        <i class="ti ti-arrow-right"></i> Marquer comme dépensé
                                                                    </a>
                                                                @endif
                                                                <a class="dropdown-item" wire:click="edit_transaction('{{ $ligne->id }}')"><i class="ti ti-edit"></i> Modifier</a>
                                                                <a class="dropdown-item text-danger" wire:click="delete_transaction('{{ $ligne->id }}')"
                                                                    wire:confirm="Supprimer « {{ $ligne->name }} » ?"><i class="ti ti-trash"></i> Supprimer</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr><td colspan="4" class="text-muted text-center">Aucune ligne.</td></tr>
                                            @endforelse
                                        </tbody>
                                        <tfoot>
                                            <tr class="fw-bold">
                                                <td colspan="2">Total</td>
                                                <td class="text-end text-nowrap">{{ number_format($somme, 0, ',', ' ') }} F</td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- Modales --}}
    @component('components.modal', ["id"=>'editProject', 'title' => 'Editer un projet', 'method'=>'update'])
        <form class="row align-items-center" wire:submit="update">
            @include('_form.myproject_form')
        </form>
        <script> window.addEventListener('open-editProject', event => { window.$('#editProject').modal('show'); }) </script>
        <script> window.addEventListener('close-editProject', event => { window.$('#editProject').modal('hide'); }) </script>
    @endcomponent

    @component('components.modal', ["id"=>'addProjectFile', 'title' => 'Ajouter des fichiers', 'method'=>'store_files'])
        <form wire:submit="store_files">
            <div wire:loading wire:target="files" class="mb-2">
                Chargement <div class="spinner-border spinner-border-sm" role="status"></div>
            </div>
            <input type="file" class="form-control" multiple wire:model="files"
                @if ($file_type === 'photos') accept="image/*" @endif>
            <div class="form-hint">{{ $file_type === 'photos' ? 'Images, 8 Mo maximum par fichier.' : 'Tout type de document, 20 Mo maximum par fichier.' }}</div>
            @error('files') <span class='text-danger'>{{ $message }}</span> @enderror
            @error('files.*') <span class='text-danger'>{{ $message }}</span> @enderror
        </form>
        <script> window.addEventListener('open-addProjectFile', event => { window.$('#addProjectFile').modal('show'); }) </script>
        <script> window.addEventListener('close-addProjectFile', event => { window.$('#addProjectFile').modal('hide'); }) </script>
    @endcomponent

    @component('components.modal', ["id"=>'editProjectLink', 'title' => 'Lien de recherche', 'method'=>'save_link'])
        <form class="row" wire:submit="save_link">
            <div class="col-md-12 mb-3">
                <label class="form-label">Nom</label>
                <input type="text" class="form-control" wire:model="link_name" placeholder="Tutoriel, boutique, documentation…">
                @error('link_name') <span class='text-danger'>{{ $message }}</span> @enderror
            </div>
            <div class="col-md-12 mb-3">
                <label class="form-label">URL</label>
                <input type="url" class="form-control" wire:model="link_url" placeholder="https://…">
                @error('link_url') <span class='text-danger'>{{ $message }}</span> @enderror
            </div>
            <div class="col-md-12 mb-3">
                <label class="form-label">Description</label>
                <textarea class="form-control" rows="3" wire:model="link_description"></textarea>
            </div>
        </form>
        <script> window.addEventListener('open-editProjectLink', event => { window.$('#editProjectLink').modal('show'); }) </script>
        <script> window.addEventListener('close-editProjectLink', event => { window.$('#editProjectLink').modal('hide'); }) </script>
    @endcomponent

    @component('components.modal', ["id"=>'editProjectNote', 'title' => 'Note', 'method'=>'save_note'])
        <form class="row" wire:submit="save_note">
            <div class="col-md-12 mb-3">
                <label class="form-label">Titre</label>
                <input type="text" class="form-control" wire:model="note_title" placeholder="Titre de la note">
                @error('note_title') <span class='text-danger'>{{ $message }}</span> @enderror
            </div>
            {{-- Éditeur markdown : wire:ignore car EasyMDE remplace le champ --}}
            <div class="col-md-12 mb-3">
                <label class="form-label">Contenu</label>
                <div wire:ignore>
                    <textarea id="myproject-note-content" class="form-control" data-markdown-editor
                        data-markdown-model="note_content" data-markdown-height="200px"
                        placeholder="**Gras**, *italique*, # titres, - listes, [lien](url)…"></textarea>
                </div>
            </div>
        </form>
        <script> window.addEventListener('open-editProjectNote', event => { window.$('#editProjectNote').modal('show'); }) </script>
        <script> window.addEventListener('close-editProjectNote', event => { window.$('#editProjectNote').modal('hide'); }) </script>
    @endcomponent

    @component('components.modal', ["id"=>'editProjectTransaction', 'title' => 'Ligne de budget', 'method'=>'save_transaction'])
        <form class="row" wire:submit="save_transaction">
            <div class="col-md-6 mb-3">
                <label class="form-label">Type</label>
                <select class="form-select" wire:model="transaction_type">
                    <option value="prevision">Achat prévisionnel</option>
                    <option value="depense">Dépense</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Date</label>
                <input type="date" class="form-control" wire:model="transaction_date">
            </div>
            <div class="col-md-12 mb-3">
                <label class="form-label">Libellé</label>
                <input type="text" class="form-control" wire:model="transaction_name" placeholder="Carte Zigbee, capteurs…">
                @error('transaction_name') <span class='text-danger'>{{ $message }}</span> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Montant unitaire</label>
                <input type="number" step="0.01" min="0" class="form-control" wire:model="transaction_amount">
                @error('transaction_amount') <span class='text-danger'>{{ $message }}</span> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Quantité</label>
                <input type="number" min="1" class="form-control" wire:model="transaction_quantity">
                @error('transaction_quantity') <span class='text-danger'>{{ $message }}</span> @enderror
            </div>
            <div class="col-md-12 mb-3">
                <label class="form-label">Description</label>
                <textarea class="form-control" rows="3" wire:model="transaction_description"></textarea>
            </div>
        </form>
        <script> window.addEventListener('open-editProjectTransaction', event => { window.$('#editProjectTransaction').modal('show'); }) </script>
        <script> window.addEventListener('close-editProjectTransaction', event => { window.$('#editProjectTransaction').modal('hide'); }) </script>
    @endcomponent
</div>
