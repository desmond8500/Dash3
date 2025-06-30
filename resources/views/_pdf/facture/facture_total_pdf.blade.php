<table class="mt-1">
    <tr>
        <td style="width: 400px; padding-top: 20px" align="center" >
            <img src="{{ env('BUFFER') }}" alt="" height="70px">
            <img src="{{ env('SIGN') }}" alt="" height="70px">
        </td>
        <td>
            <table class="fw-bold" style="background: #dddddd">
                <tr>
                    <td>TOTAL HT</td>
                    <td class="text-end">{{ number_format($total_marge, 0,'.', ' ') }} F CFA</td>
                </tr>

                @if ($devis->tax == 'tva')
                    <tr><td>TVA</td>
                        <td class="text-end">{{ $total_marge * 0.18 }} F CFA</td>
                    </tr>
                @elseif($devis->tax == 'brs')
                    <tr><td>BRS</td>
                        <td class="text-end">{{ $total_marge * 0.05 }} 0 F CFA</td>
                    </tr>
                @else
                    <tr>
                        <td>TVA</td>
                        <td class="text-end">0 F CFA</td>
                    </tr>
                @endif
                <tr>
                    <td>TOTAL TTC</td>
                    <td class="text-end">{{ number_format($total_marge, 0,'.', ' ') }} F CFA</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
