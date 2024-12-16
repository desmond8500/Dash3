<table class="table mb-1">
    <tr>
        <td colspan="3" class="text-center bg-green" style="background: #{{ $color1 }}">{{ strtoupper("Bordereau de $bl->type") }}</td>
    </tr>
    <tr>
        <td width="50px">
            <img src="{{ $logo }}" width="50px" alt="Logo">
        </td>
        <td>
            <div><b>Client :</b> {{ $invoice->projet->client->name }}</div>
            <div><b>Projet :</b> {{ $invoice->projet->name }}</div>
        </td>
        <td width="200px" class="text-end">
            <div>{{ $carbon->format('d-m-Y')}}</div>
            <div> <span class="text-muted">#{{ strtoupper($invoice->reference) }}</span></div>
        </td>
    </tr>
</table>

<table class="table mb-1">
    <tr>
        <td colspan="3" >
            <div class="fw-bold">Description :</div>
            <div>@parsedown($invoice->description)</div>
        </td>
    </tr>
</table>

@if ($bl->done)
    <table class="table mb-1">
        <tr>
            <td colspan="3" >
                <div class="fw-bold">Travaux Effectués :</div>
                <div>@parsedown($bl->done)</div>
            </td>
        </tr>
    </table>
@endif

@if ($bl->todo)
    <table class="table mb-1">
        <tr>
            <td colspan="3" >
                <div class="fw-bold">Travaux restants :</div>
                <div>@parsedown($bl->todo)</div>
            </td>
        </tr>
    </table>
@endif

