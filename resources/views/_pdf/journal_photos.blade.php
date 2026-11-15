{{--
    Galerie de photos d'un journal ou d'une section : chaque vignette est
    encadrée et légendée. En tableau, dompdf ne gérant ni flex ni grid.
--}}
@php
    $visibles = ($photos ?? collect())->filter(fn ($p) => is_file(public_path($p->folder)))->values();
    $parLigne = $parLigne ?? 2;
    $prefixe = $prefixe ?? '';
@endphp

@if ($visibles->count())
    <table class="plain shots">
        @foreach ($visibles->chunk($parLigne) as $ligne)
            <tr>
                @foreach ($ligne as $photo)
                    <td class="shot avoid-break" width="{{ round(100 / $parLigne) }}%">
                        <div class="frame">
                            <img src="{{ public_path($photo->folder) }}" alt="">
                            <div class="caption">
                                <span class="num">{{ $prefixe }}{{ $loop->parent->iteration * $parLigne - $parLigne + $loop->iteration }}.</span>
                                {{ $photo->caption ?: 'Photo' }}
                            </div>
                        </div>
                    </td>
                @endforeach
                @for ($i = $ligne->count(); $i < $parLigne; $i++)
                    <td class="shot"></td>
                @endfor
            </tr>
        @endforeach
    </table>
@endif
