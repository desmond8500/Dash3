<div class="row g-2 p-2">
    <div class="col">
        <img src="{{ public_path('img/tyto/tampon.jpg') }}" alt="" style="height: 80px">
    </div>
    <div class="col">
        <img src="{{ public_path('img/tyto/signature.jpg') }}" alt="" style="height: 70px">
    </div>
    <div class="col">
        <table class="fw-bold table table-bordered table-sm">
            <tr>
                <td>TOTAL HT</td>
                <td class="text-end">{{ number_format($total_marge, 0, '.', ' ') }} F CFA</td>
            </tr>

            @if ($invoice->tax == 'tva')
                <tr>
                    <td>TVA</td>
                    <td class="text-end">{{ number_format($total_marge * 0.18, 0, '.', ' ') }} F CFA</td>
                </tr>
            @elseif($invoice->tax == 'brs')
                <tr>
                    <td>BRS</td>
                    <td class="text-end">{{ number_format($total_marge * 0.05, 0, '.', ' ') }} F CFA</td>
                </tr>
            @else
                <tr>
                    <td>TVA</td>
                    <td class="text-end">0 F CFA</td>
                </tr>
            @endif
            @if ($invoice->remise > 0)
                <tr>
                    <td>Remise {{ $invoice->remise * 100 }}%</td>
                    <td class="text-end">{{ number_format($total_marge * $invoice->remise, 0, '.', ' ') }} F CFA</td>
                </tr>
            @endif
            <tr>
                <td>TOTAL TTC</td>
                <td class="text-end">
                    @if ($invoice->tax == 'tva')
                        {{ number_format($total_marge * 1.18 - $total_marge * $invoice->remise, 0, '.', ' ') }}
                    @elseif($invoice->tax == 'brs')
                        {{ number_format( $total_marge - $total_marge * 0.05 - $total_marge * $invoice->remise, 0, '.', ' ', ) }}
                    @else
                        {{ number_format($total_marge - $total_marge * $invoice->remise, 0, '.', ' ') }}
                    @endif
                    F CFA
                </td>
            </tr>
        </table>
    </div>
</div>
