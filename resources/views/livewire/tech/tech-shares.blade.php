<div>
    @php
        $categories = [
            'info' => ['Information', 'info-circle'],
            'materiel' => ['Matériel', 'package'],
            'acces' => ['Accès', 'key'],
            'document' => ['Document', 'file'],
        ];
    @endphp

    <div class="row g-2 mb-3 align-items-center">
        <div class="col-md-auto">
            <div class="btn-group">
                <button class="btn {{ $status === 'active' ? 'btn-primary' : 'btn-outline-primary' }}" wire:click="$set('status', 'active')">En cours</button>
                <button class="btn {{ $status === 'expired' ? 'btn-primary' : 'btn-outline-primary' }}" wire:click="$set('status', 'expired')">Expirées</button>
            </div>
        </div>
        <div class="col-md">
            <div class="input-icon">
                <input type="text" class="form-control" wire:model.live.debounce.300ms="search" placeholder="Chercher un titre">
                <span class="input-icon-addon"><i class="ti ti-search"></i></span>
            </div>
        </div>
        <div class="col-md-auto">
            <button class="btn btn-primary" wire:click="create" @disabled($technicians->isEmpty())>
                <i class="ti ti-share"></i> Partager une information
            </button>
        </div>
    </div>

    <p class="text-muted small">
        Chaque information est temporaire. Vous êtes prévenu {{ $warnHours }} h avant son expiration ;
        à l'échéance, son contenu et son fichier sont effacés et elle disparaît des téléphones.
    </p>

    <div class="table-responsive">
        <table class="table table-vcenter card-table">
            <thead>
                <tr>
                    <th>Information</th>
                    <th>Liée à</th>
                    <th>Destinataires</th>
                    <th>{{ $status === 'active' ? 'Expiration' : 'Expirée le' }}</th>
                    @if ($status === 'active') <th class="w-1"></th> @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($shares as $share)
                    @php
                        [$catLabel, $catIcon] = $categories[$share->category] ?? $categories['info'];
                        $hoursLeft = $share->expires_at ? now()->diffInHours($share->expires_at, false) : null;
                    @endphp
                    <tr wire:key="share-{{ $share->id }}">
                        <td>
                            <div class="fw-bold"><i class="ti ti-{{ $catIcon }} text-muted"></i> {{ $share->title }}</div>
                            <div class="text-muted small">
                                {{ $catLabel }}
                                @if ($share->file_name)
                                    · <a href="{{ route('tech.share_file', $share->id) }}" target="_blank"><i class="ti ti-paperclip"></i>{{ $share->file_name }}</a>
                                @endif
                                @if ($share->creator) · par {{ $share->creator->firstname }} @endif
                            </div>
                        </td>
                        <td class="small">
                            @if ($share->task) <div><i class="ti ti-clipboard-list"></i> {{ $share->task->name }}</div> @endif
                            @if ($share->article) <div><i class="ti ti-package"></i> {{ $share->article->designation }}</div> @endif
                            @if (! $share->task && ! $share->article) <span class="text-muted">—</span> @endif
                        </td>
                        <td>
                            @foreach ($share->technicians as $tech)
                                <span class="badge {{ $tech->pivot->read_at ? 'bg-success-lt' : 'bg-secondary-lt' }}"
                                    title="{{ $tech->pivot->read_at ? 'Lue le '.\Illuminate\Support\Carbon::parse($tech->pivot->read_at)->format('d/m/Y H:i') : 'Pas encore lue' }}">
                                    @if ($tech->pivot->read_at)<i class="ti ti-eye"></i>@endif
                                    {{ $tech->firstname }}
                                </span>
                            @endforeach
                        </td>
                        <td class="text-nowrap">
                            @if ($status === 'active')
                                <span class="badge {{ $hoursLeft !== null && $hoursLeft < 6 ? 'bg-danger' : ($hoursLeft !== null && $hoursLeft < $warnHours ? 'bg-warning' : 'bg-secondary-lt') }}">
                                    {{ $share->expires_at?->diffForHumans() }}
                                </span>
                                <div class="text-muted small">
                                    {{ $share->expires_at?->format('d/m/Y H:i') }}
                                    @if ($share->expires_with_task) <br>ou fin de la tâche @endif
                                </div>
                            @else
                                {{ $share->expired_at?->format('d/m/Y H:i') }}
                            @endif
                        </td>
                        @if ($status === 'active')
                            <td class="text-nowrap">
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-primary" wire:click="extend({{ $share->id }}, 1)" title="Prolonger d'un jour">+1 j</button>
                                    <button class="btn btn-outline-primary" wire:click="extend({{ $share->id }}, 7)" title="Prolonger d'une semaine">+7 j</button>
                                </div>
                                <button class="btn btn-sm btn-outline-primary btn-icon" wire:click="edit({{ $share->id }})" title="Modifier"><i class="ti ti-edit"></i></button>
                                <button class="btn btn-sm btn-outline-danger btn-icon" wire:click="withdraw({{ $share->id }})"
                                    wire:confirm="Retirer cette information maintenant ? Son contenu sera effacé." title="Retirer"><i class="ti ti-eye-off"></i></button>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-muted text-center py-4">{{ $status === 'active' ? 'Aucune information en cours.' : 'Aucune information expirée.' }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-2">{{ $shares->links() }}</div>

    @component('components.modal', ['id' => 'techShare', 'title' => $editingId ? 'Modifier l\'information' : 'Partager une information', 'method' => 'save', 'submit' => $editingId ? 'Enregistrer' : 'Partager', 'class' => 'modal-lg'])
        <form class="row" wire:submit="save">
            <div class="col-md-4 mb-3">
                <label class="form-label">Type</label>
                <select class="form-select" wire:model="category">
                    @foreach ($categories as $key => [$label, $icon])
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
                @error('category') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-8 mb-3">
                <label class="form-label required">Titre</label>
                <input type="text" class="form-control" wire:model="title" placeholder="Ex. Code d'accès local technique">
                @error('title') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>

            <div class="col-md-12 mb-3">
                <label class="form-label">Contenu</label>
                <textarea class="form-control" rows="5" wire:model="content" placeholder="Consignes, codes, procédure de pose…"></textarea>
                @error('content') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>

            {{-- Tâche --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Tâche</label>
                @if ($selectedTask)
                    <div class="d-flex align-items-center border rounded p-2">
                        <i class="ti ti-clipboard-list me-2"></i>
                        <span class="flex-fill">{{ $selectedTask->name }}</span>
                        <button type="button" class="btn-close" wire:click="clearTask"></button>
                    </div>
                @else
                    <input type="text" class="form-control" wire:model.live.debounce.300ms="taskSearch" placeholder="Chercher une tâche (facultatif)">
                    @if ($taskResults->isNotEmpty())
                        <div class="list-group mt-1">
                            @foreach ($taskResults as $t)
                                <a href="#" class="list-group-item list-group-item-action py-1" wire:click.prevent="selectTask({{ $t->id }})" wire:key="tr-{{ $t->id }}">
                                    {{ $t->name }} <span class="text-muted small">{{ $t->projet?->name }}</span>
                                </a>
                            @endforeach
                        </div>
                    @endif
                @endif
                @error('task_id') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>

            {{-- Article --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Matériel (fiche article)</label>
                @if ($selectedArticle)
                    <div class="d-flex align-items-center border rounded p-2">
                        <i class="ti ti-package me-2"></i>
                        <span class="flex-fill">{{ $selectedArticle->designation }} <span class="text-muted small">{{ $selectedArticle->reference }}</span></span>
                        <button type="button" class="btn-close" wire:click="clearArticle"></button>
                    </div>
                    <div class="form-hint">Le technicien voit la désignation, la référence, la description et les caractéristiques — jamais le prix.</div>
                @else
                    <input type="text" class="form-control" wire:model.live.debounce.300ms="articleSearch" placeholder="Désignation ou référence (facultatif)">
                    @if ($articleResults->isNotEmpty())
                        <div class="list-group mt-1">
                            @foreach ($articleResults as $a)
                                <a href="#" class="list-group-item list-group-item-action py-1" wire:click.prevent="selectArticle({{ $a->id }})" wire:key="ar-{{ $a->id }}">
                                    {{ $a->designation }} <span class="text-muted small">{{ $a->reference }}</span>
                                </a>
                            @endforeach
                        </div>
                    @endif
                @endif
                @error('article_id') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>

            {{-- Destinataires --}}
            <div class="col-md-12 mb-3">
                <label class="form-label">Destinataires</label>
                <div class="d-flex flex-wrap gap-2">
                    @foreach ($technicians as $tech)
                        <label class="form-selectgroup-item" wire:key="dest-{{ $tech->id }}">
                            <input type="checkbox" class="form-selectgroup-input" value="{{ $tech->id }}" wire:model="technician_ids">
                            <span class="form-selectgroup-label">{{ $tech->firstname }} {{ $tech->lastname }}</span>
                        </label>
                    @endforeach
                </div>
                <div class="form-hint">Avec une tâche, laisser vide = les techniciens affectés à la tâche.</div>
                @error('technician_ids') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>

            {{-- Expiration --}}
            <div class="col-md-6 mb-3">
                <label class="form-label required">Disponible jusqu'au</label>
                <input type="datetime-local" class="form-control" wire:model="expires_at">
                <div class="btn-group btn-group-sm mt-1">
                    <button type="button" class="btn btn-outline-secondary" wire:click="setDuration(1)">1 jour</button>
                    <button type="button" class="btn btn-outline-secondary" wire:click="setDuration(3)">3 jours</button>
                    <button type="button" class="btn btn-outline-secondary" wire:click="setDuration(7)">1 semaine</button>
                    <button type="button" class="btn btn-outline-secondary" wire:click="setDuration(30)">1 mois</button>
                </div>
                @error('expires_at') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">&nbsp;</label>
                <label class="form-check">
                    <input type="checkbox" class="form-check-input" wire:model="expires_with_task" @disabled(! $selectedTask)>
                    <span class="form-check-label">Expire aussi à la fin de la tâche</span>
                </label>
                <div class="form-hint">
                    {{ config('tech.task_close_grace_hours', 24) }} h après le passage de la tâche en « Terminé », si c'est avant la date choisie.
                </div>
            </div>

            {{-- Fichier --}}
            <div class="col-md-12 mb-1">
                <label class="form-label">Pièce jointe</label>
                <input type="file" class="form-control" wire:model="file">
                <div wire:loading wire:target="file" class="small text-muted">Envoi du fichier…</div>
                <div class="form-hint">Plan, schéma, notice… Visible en ligne uniquement, effacée à l'expiration.</div>
                @error('file') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
        </form>
        <script> window.addEventListener('open-techShare', () => window.$('#techShare').modal('show')) </script>
        <script> window.addEventListener('close-techShare', () => window.$('#techShare').modal('hide')) </script>
    @endcomponent
</div>
