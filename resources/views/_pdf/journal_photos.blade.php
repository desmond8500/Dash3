{{--
    Galerie de photos d'un journal ou d'une section, en tableau : dompdf ne
    gère ni flex ni grid. $photos est une collection de JournalImage.
--}}
@php
    $visibles = ($photos ?? collect())->filter(fn ($p) => is_file(public_path($p->folder)))->values();
    $parLigne = $parLigne ?? 3;
@endphp

@if ($visibles->count())
    <table class="plain avoid-break" style="margin-top: 6px;">
        @foreach ($visibles->chunk($parLigne) as $ligne)
            <tr>
                @foreach ($ligne as $photo)
                    <td class="shot" width="{{ round(100 / $parLigne) }}%">
                        <img src="{{ public_path($photo->folder) }}" alt="">
                    </td>
                @endforeach
                @for ($i = $ligne->count(); $i < $parLigne; $i++)
                    <td class="shot"></td>
                @endfor
            </tr>
        @endforeach
    </table>
@endif
