<div>
    @php
        $statuses = [
            'pending' => ['En attente', 'warning'],
            'approved' => ['Acceptée', 'success'],
            'rejected' => ['Refusée', 'danger'],
        ];
    @endphp

    <div class="btn-group mb-3">
        @foreach (['pending' => 'En attente', 'approved' => 'Acceptées', 'rejected' => 'Refusées', 'all' => 'Toutes'] as $key => $label)
            <button class="btn {{ $status === $key ? 'btn-primary' : 'btn-outline-primary' }}" wire:click="$set('status', '{{ $key }}')">{{ $label }}</button>
        @endforeach
    </div>

    <div class="list-group">
        @forelse ($requests as $req)
            @php [$label, $color] = $statuses[$req->status] ?? [$req->status, 'secondary']; @endphp
            <div class="list-group-item" wire:key="req-{{ $req->id }}">
                <div class="d-flex align-items-start">
                    <span class="avatar avatar-sm bg-{{ $color }}-lt me-3"><i class="ti ti-key"></i></span>
                    <div class="flex-fill">
                        <div class="fw-bold">{{ $req->subject }}</div>
                        <div class="text-muted small">
                            {{ $req->user?->firstname }} {{ $req->user?->lastname }} · {{ $req->created_at->diffForHumans() }}
                            @if ($req->task) · <i class="ti ti-clipboard-list"></i> {{ $req->task->name }} @endif
                            @if ($req->article) · <i class="ti ti-package"></i> {{ $req->article->designation }} @endif
                        </div>
                        @if ($req->reason)
                            <div class="mt-1" style="white-space: pre-wrap">{{ $req->reason }}</div>
                        @endif
                        @if ($req->status !== 'pending')
                            <div class="small mt-1">
                                <span class="badge bg-{{ $color }}-lt">{{ $label }}</span>
                                @if ($req->decider) par {{ $req->decider->firstname }} le {{ $req->decided_at?->format('d/m/Y H:i') }} @endif
                                @if ($req->share)
                                    · accès {{ $req->share->isActive() ? "jusqu'au ".$req->share->expires_at?->format('d/m/Y H:i') : 'terminé' }}
                                @endif
                                @if ($req->response) <div class="text-muted">« {{ $req->response }} »</div> @endif
                            </div>
                        @endif
                    </div>
                    @if ($req->status === 'pending')
                        <div class="ms-2 text-nowrap">
                            <button class="btn btn-sm btn-success" wire:click="approve({{ $req->id }})"><i class="ti ti-check"></i> Accorder</button>
                            <button class="btn btn-sm btn-outline-danger" wire:click="reject({{ $req->id }})"><i class="ti ti-x"></i> Refuser</button>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-muted text-center py-4">Aucune demande.</div>
        @endforelse
    </div>

    @component('components.modal', ['id' => 'techApprove', 'title' => 'Accorder l\'accès', 'method' => 'confirmApprove', 'submit' => 'Accorder', 'class' => 'modal-lg'])
        @if ($current)
            <p class="text-muted small">
                Demande de <strong>{{ $current->user?->firstname }} {{ $current->user?->lastname }}</strong> : {{ $current->subject }}.
                L'information ne sera visible que par lui, jusqu'à la date choisie.
            </p>
        @endif
        <form class="row" wire:submit="confirmApprove">
            <div class="col-md-12 mb-3">
                <label class="form-label required">Titre</label>
                <input type="text" class="form-control" wire:model="title">
                @error('title') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-12 mb-3">
                <label class="form-label">Information transmise</label>
                <textarea class="form-control" rows="5" wire:model="content" placeholder="Code, consigne, contact…"></textarea>
                @error('content') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-12 mb-3">
                <label class="form-label">Fichier</label>
                <input type="file" class="form-control" wire:model="file">
                <div wire:loading wire:target="file" class="small text-muted">Envoi du fichier…</div>
                @error('file') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label required">Accès jusqu'au</label>
                <input type="datetime-local" class="form-control" wire:model="expires_at">
                <div class="btn-group btn-group-sm mt-1">
                    <button type="button" class="btn btn-outline-secondary" wire:click="setDuration(0)">Ce soir</button>
                    <button type="button" class="btn btn-outline-secondary" wire:click="setDuration(1)">Demain</button>
                    <button type="button" class="btn btn-outline-secondary" wire:click="setDuration(7)">1 semaine</button>
                </div>
                <div class="form-hint">{{ $maxDays }} jours maximum.</div>
                @error('expires_at') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Message au technicien</label>
                <textarea class="form-control" rows="3" wire:model="response" placeholder="Facultatif"></textarea>
            </div>
        </form>
        <script> window.addEventListener('open-techApprove', () => window.$('#techApprove').modal('show')) </script>
        <script> window.addEventListener('close-techApprove', () => window.$('#techApprove').modal('hide')) </script>
    @endcomponent

    @component('components.modal', ['id' => 'techReject', 'title' => 'Refuser la demande', 'method' => 'confirmReject', 'submit' => 'Refuser'])
        <label class="form-label">Motif (visible par le technicien)</label>
        <textarea class="form-control" rows="3" wire:model="response" placeholder="Facultatif"></textarea>
        @error('response') <span class="text-danger small">{{ $message }}</span> @enderror
        <script> window.addEventListener('open-techReject', () => window.$('#techReject').modal('show')) </script>
        <script> window.addEventListener('close-techReject', () => window.$('#techReject').modal('hide')) </script>
    @endcomponent
</div>
