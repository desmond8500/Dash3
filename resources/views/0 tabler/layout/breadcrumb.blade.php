<div class="page-header">
    <div class="row align-items-center mw-100">
        <div class="col">
            <div class="mb-1">
            <ol class="breadcrumb breadcrumb-alternate" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="{{ route('tabler.index') }}">Accueil</a></li>
                @yield('breadcrumb')
            </ol>
            </div>
            <h2 class="page-title">
            <span class="text-truncate">@yield('page-title' ?? 'page-title')</span>
            </h2>
        </div>
        <div class="col-auto">
            <div class="btn-list">
                @yield('page-action')
            </div>
        </div>
    </div>
</div>
