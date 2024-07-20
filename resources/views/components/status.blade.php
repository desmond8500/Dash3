<div>
    {{-- Status
    @if ($status->name=="Nouveau")
        <div class="status status-primary">
            <span class="status-dot"></span>
            {{ $status->name }}
        </div>

    @else
    @endif --}}

    <div class="status status-{{ $color ?? '' }}">
        <span class="status-dot"></span>
        {{ $status }}
    </div>
</div>
