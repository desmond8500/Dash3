<span class="status status-{{ $color ?? 'blue' }} {{ $class ?? '' }}">
    @isset($dot)
        <span class="status-dot"></span>
    @endisset
    {{ $slot }}
</span>
