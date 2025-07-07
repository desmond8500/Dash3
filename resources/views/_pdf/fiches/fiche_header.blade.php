<div class="header">
    <div class="page_title">{{ $page_title ?? "Fiche D'exploitation" }}</div>
    <table class="table">
        <tr>
            <td width="68px" align="right" class="border-white ">
                <img src="{{ $logo }}" alt="{{ $logo }}" class="logo">
            </td>
            <td class="border-white">
                <div class="structure_title">
                    {{ $title }}
                    @isset($fiche)
                        @if ($fiche->client)
                            <div >{{ $fiche->client }}</div>
                        @endif
                    @endisset
                </div>
            </td>
            <td class="border-white" style="font-size: 13px; align: right; width: 68px; ">
                <div>{{ $fiche->formatDate() }}</div>
            </td>

        </tr>
    </table>
</div>
