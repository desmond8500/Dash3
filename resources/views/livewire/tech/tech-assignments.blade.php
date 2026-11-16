<div>
    <div class="row g-2 mb-3">
        <div class="col-md-5">
            <div class="input-icon">
                <input type="text" class="form-control" wire:model.live.debounce.300ms="search" placeholder="Tâche, projet ou client">
                <span class="input-icon-addon"><i class="ti ti-search"></i></span>
            </div>
        </div>
        <div class="col-md-4">
            <select class="form-select" wire:model.live="scope">
                <option value="open">Tâches en cours</option>
                <option value="assigned">En cours, affectées</option>
                <option value="unassigned">En cours, sans technicien</option>
                <option value="all">Toutes les tâches</option>
            </select>
        </div>
        <div class="col-md-3">
            <select class="form-select" wire:model.live="technicianFilter">
                <option value="">Tous les techniciens</option>
                @foreach ($technicians as $tech)
                    <option value="{{ $tech->id }}">{{ $tech->firstname }} {{ $tech->lastname }}</option>
                @endforeach
            </select>
        </div>
    </div>

    @if ($technicians->isEmpty())
        <div class="alert alert-info">
            Aucun compte technicien pour l'instant.
            <a href="#" wire:click.prevent="$dispatch('tech-tab', { tab: 'comptes' })">Créer un compte</a>.
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-vcenter card-table">
            <thead>
                <tr>
                    <th>Tâche</th>
                    <th>Lieu</th>
                    <th>Statut</th>
                    <th>Techniciens</th>
                    <th class="w-1"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tasks as $task)
                    <tr wire:key="task-{{ $task->id }}">
                        <td>
                            <div class="fw-bold">{{ $task->name }}</div>
                            <div class="text-muted small">{{ $task->projet?->name ?? '—' }}</div>
                        </td>
                        <td class="text-muted small">
                            {{ collect([$task->client?->name, $task->building?->name, $task->room?->name])->filter()->join(' · ') ?: '—' }}
                        </td>
                        <td><span class="badge bg-secondary-lt">{{ $task->statut?->name ?? '—' }}</span></td>
                        <td>
                            @forelse ($task->technicians as $tech)
                                <span class="badge bg-primary-lt">{{ $tech->firstname }} {{ $tech->lastname }}</span>
                            @empty
                                <span class="text-muted small">Aucun</span>
                            @endforelse
                        </td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary text-nowrap" wire:click="assign({{ $task->id }})" @disabled($technicians->isEmpty())>
                                <i class="ti ti-user-check"></i> Affecter
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-muted text-center py-4">Aucune tâche.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-2">{{ $tasks->links() }}</div>

    @component('components.modal', ['id' => 'techAssign', 'title' => 'Affecter des techniciens', 'method' => 'save', 'submit' => 'Enregistrer'])
        @if ($current)
            <p class="fw-bold mb-1">{{ $current->name }}</p>
            <p class="text-muted small">
                Les informations déjà partagées sur cette tâche suivront : les techniciens ajoutés les reçoivent,
                ceux retirés n'y ont plus accès.
            </p>
        @endif
        <div class="list-group">
            @foreach ($technicians as $tech)
                <label class="list-group-item d-flex align-items-center" wire:key="sel-{{ $tech->id }}">
                    <input class="form-check-input me-2" type="checkbox" value="{{ $tech->id }}" wire:model="selected">
                    <span class="flex-fill">{{ $tech->firstname }} {{ $tech->lastname }}</span>
                    <span class="text-muted small">{{ $tech->function }}</span>
                </label>
            @endforeach
        </div>
        <script> window.addEventListener('open-techAssign', () => window.$('#techAssign').modal('show')) </script>
        <script> window.addEventListener('close-techAssign', () => window.$('#techAssign').modal('hide')) </script>
    @endcomponent
</div>
