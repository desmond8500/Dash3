<div>
    <div>
        {{ env('APP_NAME') }}
        @if (env('EMAIL'))
            -
        @endif
        {{ env('EMAIL') }}
    </div>
    <div>
        {{ env('NINEA') }}
        @if (env('RIB'))
        -
        @endif {{ env('RIB') }}
    </div>
</div>
