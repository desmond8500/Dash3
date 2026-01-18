{{-- <div>
    {{ $company_name}} {{ $date }}
    <div>
        {{ $company_name ?? 'Company Nam' }} sq
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
</div> --}}
<style>
    .footer {
        position: fixed;
        bottom: 30px;
        left: 0;
        right: 0;
        text-align: center;
        font-size: 10px;
    }
</style>

{{-- FOOTER --}}
<div class="footer">
    {{ config('app.name') }} – Document généré automatiquement
</div>
