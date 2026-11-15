{{-- Pied de page du devis : coordonnées de l'entreprise et numéro de page --}}
<div style="width: 100%; padding: 0 14mm; font-family: Arial, sans-serif; font-size: 9px; color: #6c757d;">
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="text-align: left;">
                <div>{{ env('APP_NAME', config('app.name')) }}@if (env('EMAIL')) - {{ env('EMAIL') }}@endif</div>
                <div>{{ env('NINEA') }}@if (env('RIB')) - {{ env('RIB') }}@endif</div>
            </td>
            <td style="text-align: right; vertical-align: bottom;">
                Page <span class="pageNumber"></span> / <span class="totalPages"></span>
            </td>
        </tr>
    </table>
</div>
