<div class="page-header mb-2 mt-2">
    <div class="row ">
        <div class="col">
            <div class="mb-1">
                <ol class="breadcrumb" aria-label="breadcrumbs">
                    <li class="breadcrumb-item">
                        <a href="{{ route('index') }}" wire:navigate>
                            <i class="ti ti-home"></i>
                        </a>
                    </li>
                    @isset($breadcrumbs)
                        @foreach ($breadcrumbs as $bread)
                            @if ($loop->last)
                                <li class="breadcrumb-item active" aria-current="page"><a href="{{ $bread['route'] }}">{{ $bread['name'] }}</a></li>
                            @else
                                <li class="breadcrumb-item"><a href="{{ $bread['route'] }}" wire:navigate>{{ $bread['name'] }}</a></li>
                            @endif
                        @endforeach
                    @endisset
                </ol>
            </div>
            <h2 class="page-title">
                <span class="text-truncate">
                    <span wire:loading class="spinner-border"> </span> {{ $title ?? 'Title' }}</span>
            </h2>
        </div>
        <div class="col-xs-12 col-sm-auto ">
            {{ $slot }}
        </div>
    </div>
</div>
