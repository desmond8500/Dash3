<style>
    .signature{
        height: 70px;
        vertical-align: top;
        /* color: #C4DAD2; */
        color: grey;
    }
    .foot{
        position: absolute;
        bottom: 150px;
    }
</style>
<table class="table foot">
    <tr>
        <td rowspan="2" style="vertical-align:top">Observations du client :</td>
        <td class="signature">
            <div>Signature Technicien</div>
            <img src="{{ env('SIGN') }}" alt="" height="50px">
        </td>
    </tr>
    <tr >
        <td width="250px" class="signature">Signature client</td>
    </tr>
</table>
