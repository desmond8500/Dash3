<table class="table zone mt-1">
    <tr>
        <td colspan="2" class="title3">CONTACT DE LA MAINTENANCE</td>
    </tr>
    <tr>
        <td width="10px" style="border-right-color: white">
            <div class="number_b">
                <img src="fiches/img/phone.png" alt="">
            </div>
        </td>
        <td>
            <div class="fw-bold fs-5 text-center mb-1">En cas de dérangement Prévenez le service de Maintenance
            </div>
            @if ($fiche->phone)
            <div class="contact phone"> <i class="ti ti-user"></i> {{ $fiche->phone }}</div>
            @endif
            @if ($fiche->email)
            <div class="contact email">{{ $fiche->email }}</div>
            @endif
        </td>
    </tr>

</table>

<div class="d-flex-between">
    <div class="client"> {{ $fiche->client }} </div>
    <div>{{ $fiche->date }}</div>
</div>
