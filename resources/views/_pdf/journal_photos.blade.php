{{--
    Galerie de photos d'un journal ou d'une section, en tableau : dompdf ne
    gère ni flex ni grid. $photos est une collection de JournalImage.
--}}
@php
    $visibles = ($photos ?? collect())->filter(fn ($p) => file_exists(public_path($p->folder)))->values();
    $parLigne = $parLigne ?? 3;
@endphp

@if ($visibles->count())
    <table class="table" style="margin-top: 6px;">
        @foreach ($visibles->chunk($parLigne) as $ligne)
            <tr>
                @foreach ($ligne as $photo)
                    <td class="border_white text-center" width="{{ round(100 / $parLigne) }}%" style="padding: 3px;">
                        <img src="{{ public_path($photo->folder) }}" alt="" style="width: 100%;">
                    </td>
                @endforeach
                {{-- Cellules vides pour garder les colonnes alignées sur la dernière ligne --}}
                @for ($i = $ligne->count(); $i < $parLigne; $i++)
                    <td class="border_white"></td>
                @endfor
            </tr>
        @endforeach
    </table>
@endif
