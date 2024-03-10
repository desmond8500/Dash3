<div class="card">
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs">
            @foreach ($tabs as $key => $tab)
                <li class="nav-item {{ $tab->class }}">
                    <a href="#{{ $tab->id }}" class="nav-link {{ $selected_tab == $key ? 'active' : '' }}" wire:click="select('{{ $key }}')">
                        <i class="ti ti-{{ $tab->icon }}"></i> {{ $tab->name }}</a>
                </li>
            @endforeach
            {{-- <li class="nav-item">
                <a href="#tabs-home-ex2" class="nav-link active" data-bs-toggle="tab">
                    <i class="ti ti-home"></i> Home
                </a>
            </li>
            <li class="nav-item">
                <a href="#tabs-profile-ex2" class="nav-link" data-bs-toggle="tab">
                    <i class="ti ti-user"></i> Profile</a>
            </li>
            <li class="nav-item ms-auto">
                <a href="#tabs-settings-ex2" class="nav-link" title="Settings" data-bs-toggle="tab">
                    <i class="ti ti-settings"></i>
                </a>
            </li> --}}
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content">
            {{ $slot }}
        </div>
    </div>
</div>
