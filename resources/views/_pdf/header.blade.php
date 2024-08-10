@php
    $carbon->locale('fr_FR');
@endphp

<table class="table" style="margin-bottom: 10px;">
    <tr>
        <td width="80px" class="border-white">
            @if ($logo)
            <div style="width: 80px; height: 80px;">
                <img src="{{ $logo }}" alt="logo" style="width:100%; height:100%;">
            </div>
            @else
            <div class="logo" style="background: #{{ $color1 }}">
                <div class="text-center" style="padding-top: 30px;">Logo</div>
            </div>
            @endif
        </td>
        <td width="300px" class="border-white fw-bold" align="left" style="{{ $title_css }}; color: #{{ $color1 }}">
            <div>{{ env('MAIN_NAME') }}</div>
        </td>
        <td align="right" class="border-white">
            <div  style="font-weight:bold; font-size: 1.5rem; text-transform: uppercase; color: #{{ $color1 }};">{{ $title }}</div>
            <i>{{ $date }}</i>
        </td>
    </tr>
</table>
<hr>
