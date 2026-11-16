<div>
    @php
        $statuses = [
            'submitted' => ['À valider', 'primary'],
            'validated' => ['Validé', 'success'],
            'rejected' => ['À revoir', 'danger'],
        ];
    @endphp

    <div class="row g-2 mb-3">
        <div class="col-md-3">
            <select class="form-select" wire:model.live="status">
                <option value="submitted">À valider</option>
                <option value="validated">Validés</option>
                <option value="rejected">Renvoyés au technicien</option>
                <option value="all">Tous</option>
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
        <div class="col-md-6">
            <div class="input-icon">
                <input type="text" class="form-control" wire:model.live.debounce.300ms="search" placeholder="Chercher dans les rapports">
                <span class="input-icon-addon"><i class="ti ti-search"></i></span>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-vcenter card-table table-hover">
            <thead>
                <tr>
                    <th>Rapport</th>
                    <th>Technicien</th>
                    <th>Tâche</th>
                    <th>Date</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reports as $report)
                    @php [$label, $color] = $statuses[$report->status] ?? [$report->status, 'secondary']; @endphp
                    <tr wire:key="rep-{{ $report->id }}" role="button" wire:click="show({{ $report->id }})">
                        <td>
                            <div class="fw-bold">{{ $report->title }}</div>
                            <div class="text-muted small">
                                {{ \Illuminate\Support\Str::limit($report->content, 80) }}
                                @if ($report->photos->count()) · <i class="ti ti-photo"></i> {{ $report->photos->count() }} @endif
                            </div>
                        </td>
                        <td>{{ $report->user?->firstname }} {{ $report->user?->lastname }}</td>
                        <td class="small">{{ $report->task?->name ?? '—' }}</td>
                        <td class="small text-nowrap">{{ ($report->reported_at ?? $report->created_at)?->format('d/m/Y H:i') }}</td>
                        <td><span class="badge bg-{{ $color }}-lt">{{ $label }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-muted text-center py-4">Aucun rapport.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-2">{{ $reports->links() }}</div>

    @component('components.modal', ['id' => 'techReport', 'title' => 'Rapport d\'intervention', 'class' => 'modal-lg'])
        @if ($current)
            @php [$label, $color] = $statuses[$current->status] ?? [$current->status, 'secondary']; @endphp
            <div class="d-flex align-items-start mb-2">
                <div class="flex-fill">
                    <h3 class="mb-1">{{ $current->title }}</h3>
                    <div class="text-muted small">
                        {{ $current->user?->firstname }} {{ $current->user?->lastname }}
                        · {{ ($current->reported_at ?? $current->created_at)?->format('d/m/Y H:i') }}
                        @if ($current->task) · {{ $current->task->name }} @endif
                        @if ($current->task?->projet) ({{ $current->task->projet->name }}) @endif
                    </div>
                </div>
                <span class="badge bg-{{ $color }}-lt">{{ $label }}</span>
            </div>

            @if ($current->latitude && $current->longitude)
                <p class="small">
                    <a href="https://www.openstreetmap.org/?mlat={{ $current->latitude }}&mlon={{ $current->longitude }}#map=18/{{ $current->latitude }}/{{ $current->longitude }}" target="_blank" rel="noopener">
                        <i class="ti ti-map-pin"></i> Voir la position
                    </a>
                </p>
            @endif

            @if ($current->content)
                <div class="border rounded p-3 mb-3" style="white-space: pre-wrap">{{ $current->content }}</div>
            @endif

            @if ($current->photos->isNotEmpty())
                <div class="row g-2 mb-3">
                    @foreach ($current->photos as $photo)
                        <div class="col-4 col-md-3" wire:key="ph-{{ $photo->id }}">
                            <a href="{{ route('tech.report_photo', [$current->id, $photo->id]) }}" target="_blank">
                                <img src="{{ route('tech.report_photo', [$current->id, $photo->id]) }}" class="img-fluid rounded border" style="aspect-ratio:1;object-fit:cover" alt="{{ $photo->caption }}" loading="lazy">
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif

            @if ($current->reviewer && $current->reviewed_at)
                <p class="text-muted small">Revu par {{ $current->reviewer->firstname }} le {{ $current->reviewed_at->format('d/m/Y H:i') }}</p>
            @endif

            <label class="form-label">Retour au technicien</label>
            <textarea class="form-control" rows="3" wire:model="review_note" placeholder="Facultatif pour valider, obligatoire pour renvoyer"></textarea>
            @error('review_note') <span class="text-danger small">{{ $message }}</span> @enderror

            <div class="d-flex justify-content-end gap-2 mt-3">
                <button type="button" class="btn btn-outline-danger" wire:click="requestChanges"><i class="ti ti-arrow-back-up"></i> À revoir</button>
                <button type="button" class="btn btn-success" wire:click="validateReport"><i class="ti ti-check"></i> Valider</button>
            </div>
        @endif
        <script> window.addEventListener('open-techReport', () => window.$('#techReport').modal('show')) </script>
        <script> window.addEventListener('close-techReport', () => window.$('#techReport').modal('hide')) </script>
    @endcomponent
</div>
