<div class="header">
    <div class="page_title">Fiche D'exploitation</div>
    <table class="table">
        <tr>
            <td width="10px" align="right" class="border-white">
                <img src="{{ $logo }}" alt="" class="logo">
            </td>
            <td class="border-white">
                <div class="structure_title">
                    {{ $title }}
                    @if ($fiche->client)
                        <div style="font-size: 13px; text-transform:uppercase; ">{{ $fiche->client }}</div>
                    @endif
                </div>
            </td>
        </tr>
    </table>
</div>
