<table class="mt-1" style="font-size: 14px;">
    <tr>
        <th class="" style="background: #6b8a7a; color: white;" colspan="4">ACOMPTE</th>
    </tr>
    <thead>
        <tr style="background: #e7f0dc; ">
            <th class="text-start">Description</th>
            <th class="text-center" width="200px">Montant</th>
            <th class="text-center" width="70px">Statut</th>
            <th class="text-center" width="90px">date</th>
        </tr>

    </thead>
    @foreach ($acomptes as $acompte)
        <tr class="fw-bold @if(!$acompte->statut) bg-blue-lt @else bg-white @endif">
            <td>
                <div> {{ $acompte->name ?? 'Montant Acompte'  }} </div>
            </td>
            <td class="text-end">{{ number_format($acompte->montant, 0,'.', ' ') }} F CFA</td>
            <td>
                <div class="text-center">
                    @if ($acompte->statut)
                        Payé
                    @else
                        A Payer
                    @endif
                </div>
            </td>
            <td>
                <div class="text-center">{{ $acompte->formatDate() }}</div>
            </td>
        </tr>
    @endforeach

    <tr class="fw-bold">
        <td>
            <div>Reliquat: </div>
        </td>
        @php
            $total_acompte = 0;
            foreach ($acomptes as $acompte) {
                if ($acompte->statut == 1) {
                    $total_acompte += $acompte->montant;
                }
            }
        @endphp

        <td class="text-end" colspan="3">{{ number_format($total_marge - $total_acompte, 0,'.', ' ') }} F CFA</td>
    </tr>
</table>
