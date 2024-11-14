<table class="table mb-1">
    <tr>
        <td colspan="3" class="text-center bg-green">{{ strtoupper("Bordereau de $bl->type") }}</td>
    </tr>
    <tr>
        <td width="50px">
            <img src="{{ $logo }}" width="50px" alt="Logo">
        </td>
        <td>
            <div  class="fw-bold">Client :</div>
            <div>{{ $invoice->projet->client->name }}</div>
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
            <div>{!! $invoice->description  !!}</div>
        </td>
    </tr>
</table>

@if ($bl->done)
    <table class="table mb-1">
        <tr>
            <td colspan="3" >
                <div class="fw-bold">Travaux Effectués :</div>
                <div>{!! $bl->done  !!}</div>
            </td>
        </tr>
    </table>
@endif

@if ($bl->todo)
    <table class="table mb-1">
        <tr>
            <td colspan="3" >
                <div class="fw-bold">Travaux restants :</div>
                <div>{!! $bl->todo  !!}</div>
            </td>
        </tr>
    </table>
@endif

