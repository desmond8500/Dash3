<div>
    <div class="d-flex align-items-center mb-3">
        <p class="text-muted mb-0 flex-fill">
            Un compte technicien ne donne accès qu'à l'application Dash3Tech : ses tâches, les informations
            partagées avec lui, ses rapports et ses demandes. Pas d'accès à l'ERP, au stock ni aux prix.
        </p>
        <button class="btn btn-primary ms-3" wire:click="create"><i class="ti ti-user-plus"></i> Technicien</button>
    </div>

    <div class="table-responsive">
        <table class="table table-vcenter card-table">
            <thead>
                <tr>
                    <th>Technicien</th>
                    <th>Fonction</th>
                    <th class="text-center">Tâches en cours</th>
                    <th class="text-center">Rapports</th>
                    <th>Application</th>
                    <th class="w-1"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($technicians as $tech)
                    <tr wire:key="tech-{{ $tech->id }}">
                        <td>
                            <div class="fw-bold">{{ $tech->firstname }} {{ $tech->lastname }}</div>
                            <div class="text-muted small">{{ $tech->email }}</div>
                        </td>
                        <td class="text-muted">{{ $tech->function ?: '—' }}</td>
                        <td class="text-center">{{ $tech->tech_tasks_count }}</td>
                        <td class="text-center">{{ $tech->tech_reports_count }}</td>
                        <td>
                            @if ($tech->tokens_count)
                                <span class="badge bg-success-lt"><i class="ti ti-device-mobile"></i> connecté ({{ $tech->tokens_count }})</span>
                            @else
                                <span class="badge bg-secondary-lt">non connecté</span>
                            @endif
                        </td>
                        <td class="text-nowrap">
                            <button class="btn btn-sm btn-outline-primary btn-icon" wire:click="edit({{ $tech->id }})" title="Modifier">
                                <i class="ti ti-edit"></i>
                            </button>
                            @if ($tech->tokens_count)
                                <button class="btn btn-sm btn-outline-secondary btn-icon" wire:click="logoutDevices({{ $tech->id }})"
                                    wire:confirm="Déconnecter l'application sur tous les téléphones de ce technicien ?" title="Déconnecter les téléphones">
                                    <i class="ti ti-logout"></i>
                                </button>
                            @endif
                            <button class="btn btn-sm btn-outline-danger btn-icon" wire:click="revoke({{ $tech->id }})"
                                wire:confirm="Retirer l'accès de {{ $tech->firstname }} ? Il sera déconnecté et ne verra plus aucune information." title="Retirer l'accès">
                                <i class="ti ti-user-off"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-muted text-center py-4">Aucun technicien. Créez le premier compte.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @component('components.modal', ['id' => 'techAccount', 'title' => $editingId ? 'Modifier le technicien' : 'Nouveau technicien', 'method' => 'save', 'submit' => 'Enregistrer'])
        <form class="row" wire:submit="save">
            <div class="col-md-6 mb-3">
                <label class="form-label required">Prénom</label>
                <input type="text" class="form-control" wire:model="firstname">
                @error('firstname') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Nom</label>
                <input type="text" class="form-control" wire:model="lastname">
                @error('lastname') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label required">E-mail (identifiant)</label>
                <input type="email" class="form-control" wire:model="email" autocomplete="off">
                @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Fonction</label>
                <input type="text" class="form-control" wire:model="function" placeholder="Électricien, câbleur…">
                @error('function') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-12 mb-3">
                <label class="form-label {{ $editingId ? '' : 'required' }}">Mot de passe</label>
                <input type="password" class="form-control" wire:model="password" autocomplete="new-password"
                    placeholder="{{ $editingId ? 'Laisser vide pour ne pas changer' : '8 caractères minimum' }}">
                @error('password') <span class="text-danger small">{{ $message }}</span> @enderror
                @if ($editingId)
                    <div class="form-hint">Changer le mot de passe déconnecte l'application sur ses téléphones.</div>
                @endif
            </div>
        </form>
        <script> window.addEventListener('open-techAccount', () => window.$('#techAccount').modal('show')) </script>
        <script> window.addEventListener('close-techAccount', () => window.$('#techAccount').modal('hide')) </script>
    @endcomponent
</div>
