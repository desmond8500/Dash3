<div>
    <div class="row g-3">
        <div class="col-lg-6">
            <h3 class="mb-2"><i class="ti ti-hourglass-low text-danger"></i> Expirent bientôt</h3>
            <p class="text-muted small">
                Informations qui expirent dans moins de {{ config('tech.notify_before_hours', 24) }} h.
                Prolongez-les si les techniciens en ont encore besoin.
            </p>

            @forelse ($expiringSoon as $share)
                <div class="card card-sm mb-2" wire:key="exp-{{ $share->id }}">
                    <div class="card-body">
                        <div class="d-flex align-items-start">
                            <div class="flex-fill">
                                <div class="fw-bold">{{ $share->title }}</div>
                                <div class="text-muted small">
                                    Expire {{ $share->expires_at->diffForHumans() }} ({{ $share->expires_at->format('d/m/Y H:i') }})
                                    @if ($share->task) · {{ $share->task->name }} @endif
                                </div>
                                <div class="small">
                                    @foreach ($share->technicians as $tech)
                                        <span class="badge bg-secondary-lt">{{ $tech->firstname }} {{ $tech->lastname }}</span>
                                    @endforeach
                                </div>
                            </div>
                            <div class="btn-group btn-group-sm ms-2">
                                <button class="btn btn-outline-primary" wire:click="extend({{ $share->id }}, 1)" title="Prolonger d'un jour">+1 j</button>
                                <button class="btn btn-outline-primary" wire:click="extend({{ $share->id }}, 7)" title="Prolonger d'une semaine">+7 j</button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-muted"><i class="ti ti-check"></i> Aucune information n'expire dans les prochaines heures.</div>
            @endforelse
        </div>

        <div class="col-lg-6">
            <div class="d-flex align-items-center mb-2">
                <h3 class="mb-0 flex-fill"><i class="ti ti-bell"></i> Notifications</h3>
                <label class="form-check form-switch mb-0 me-3">
                    <input class="form-check-input" type="checkbox" wire:model.live="showRead">
                    <span class="form-check-label small">Afficher les lues</span>
                </label>
                <button class="btn btn-sm btn-outline-secondary" wire:click="markAllRead">Tout marquer lu</button>
            </div>

            <div class="list-group list-group-flush">
                @forelse ($notifications as $n)
                    @php
                        $kind = $n->data['kind'] ?? '';
                        [$icon, $color, $tab] = match ($kind) {
                            'tech_share_expiring' => ['hourglass-low', 'danger', 'informations'],
                            'tech_report' => ['file-text', 'primary', 'rapports'],
                            'tech_access_request' => ['key', 'warning', 'demandes'],
                            default => ['bell', 'secondary', 'alertes'],
                        };
                    @endphp
                    <div class="list-group-item px-0 {{ $n->read_at ? 'opacity-50' : '' }}" wire:key="notif-{{ $n->id }}">
                        <div class="d-flex align-items-start">
                            <span class="avatar avatar-sm bg-{{ $color }}-lt me-2"><i class="ti ti-{{ $icon }}"></i></span>
                            <div class="flex-fill">
                                <a href="#" class="text-reset" wire:click.prevent="open('{{ $n->id }}', '{{ $tab }}')">{{ $n->data['message'] ?? 'Notification' }}</a>
                                <div class="text-muted small">{{ $n->created_at->diffForHumans() }}</div>
                            </div>
                            @unless ($n->read_at)
                                <button class="btn btn-sm btn-ghost-secondary" wire:click="markRead('{{ $n->id }}')" title="Marquer comme lue">
                                    <i class="ti ti-check"></i>
                                </button>
                            @endunless
                        </div>
                    </div>
                @empty
                    <div class="text-muted py-3">Aucune notification.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
