<div>
    @if ($status=="Nouveau")
        <div class="status status-primary">
            <span class="status-dot"></span>
            {{ $status }}
        </div>
    @elseif ($status=="En Cours")
        <div class="status status-warning">
            <span class="status-dot"></span>
            {{ $status }}
        </div>
    @elseif ($status=="En pause")
        <div class="status">
            <span class="status-dot"></span>
            {{ $status }}
        </div>
    @elseif ($status=="Terminé")
        <div class="status status-success">
            <span class="status-dot"></span>
            {{ $status }}
        </div>
    @elseif ($status=="Proforma")
        <div class="status status-purple">
            <span class="status-dot"></span>
            {{ $status }}
        </div>
    @else
        <div class="status status-{{ $color ?? '' }}">
            <span class="status-dot"></span>
            {{ $status ?? '' }}
        </div>
    @endif
</div>
