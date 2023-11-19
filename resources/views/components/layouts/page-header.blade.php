<div class="page-header">
    <div class="row align-items-center mw-100">
        <div class="col">
            <div class="mb-1">
                <ol class="breadcrumb" aria-label="breadcrumbs">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">Accueil</a></li>
                    @isset($breadcrumbs)
                        @foreach ($breadcrumbs as $bread)
                            @if ($loop->last)
                                <li class="breadcrumb-item active" aria-current="page"><a href="{{ route($bread->route) }}">{{ $bread->name }}</a></li>
                            @else
                                <li class="breadcrumb-item"><a href="{{ route($bread->route) }}">{{ $bread->name }}</a></li>
                            @endif
                        @endforeach
                    @endisset
                </ol>
            </div>
            <h2 class="page-title">
                <span class="text-truncate">{{ $title ?? 'Title' }}</span>
            </h2>
        </div>
        <div class="col-auto">
            {{ $slot }}
        </div>
    </div>
</div>
