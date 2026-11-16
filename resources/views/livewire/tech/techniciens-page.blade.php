<div>
    @component('components.layouts.page-header', ['title' => 'Techniciens', 'breadcrumbs' => $breadcrumbs])
        <span class="text-muted small"><i class="ti ti-device-mobile"></i> Application Dash3Tech</span>
    @endcomponent

    @php
        $tabs = [
            'alertes' => ['Alertes', 'bell', 'danger'],
            'comptes' => ['Comptes', 'users', 'secondary'],
            'affectations' => ['Affectations', 'clipboard-list', null],
            'informations' => ['Informations', 'info-circle', 'secondary'],
            'rapports' => ['Rapports', 'file-text', 'primary'],
            'demandes' => ['Demandes', 'key', 'warning'],
        ];
    @endphp

    <div class="card">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs flex-nowrap overflow-auto">
                @foreach ($tabs as $key => [$label, $icon, $color])
                    <li class="nav-item">
                        <a href="#" class="nav-link text-nowrap {{ $tab === $key ? 'active' : '' }}" wire:click.prevent="setTab('{{ $key }}')">
                            <i class="ti ti-{{ $icon }} me-1"></i> {{ $label }}
                            @if ($color && ($counters[$key] ?? 0) > 0)
                                <span class="badge bg-{{ $color }} text-{{ $color }}-fg ms-2">{{ $counters[$key] }}</span>
                            @endif
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="card-body">
            @switch($tab)
                @case('comptes')
                    <livewire:tech.tech-accounts :key="'tech-accounts'" />
                    @break
                @case('affectations')
                    <livewire:tech.tech-assignments :key="'tech-assignments'" />
                    @break
                @case('informations')
                    <livewire:tech.tech-shares :key="'tech-shares'" />
                    @break
                @case('rapports')
                    <livewire:tech.tech-reports :key="'tech-reports'" />
                    @break
                @case('demandes')
                    <livewire:tech.tech-requests :key="'tech-requests'" />
                    @break
                @default
                    <livewire:tech.tech-alerts :key="'tech-alerts'" />
            @endswitch
        </div>
    </div>
</div>
