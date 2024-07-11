<table class="mt-2" style="background: #FFF8F3">
    <tr>
        <th class="bg-green2" colspan="2">ACOMPTE</th>
    </tr>
    <tr class="fw-bold">
        <td>
            <div>Montant Acompte à payer: </div>
        </td>
        <td class="text-end">{{ number_format($acompte->montant, 0,'.', ' ') }} F CFA</td>
    </tr>
    <tr class="fw-bold">
        <td>
            <div>Reliquat: </div>
        </td>
        <td class="text-end">{{ number_format($total_marge - $acompte->montant, 0,'.', ' ') }} F CFA</td>
    </tr>
</table>
