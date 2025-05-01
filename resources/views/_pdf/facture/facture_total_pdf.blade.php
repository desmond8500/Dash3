<table class="mt-3">
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
                <tr>
                    <td>TVA</td>
                    <td class="text-end">0 F CFA</td>
                </tr>
                <tr>
                    <td>TOTAL TTC</td>
                    <td class="text-end">{{ number_format($total_marge, 0,'.', ' ') }} F CFA</td>
                </tr>
            </table>

        </td>
    </tr>

</table>
