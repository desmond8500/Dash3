<div class="card" >
    <div class="p-2">
        @if ($item->image)
            <img src="{{ asset($item->image) }}" class="card-img-top" alt="...">
        @else
            <div style="height: 100px; width: 100%; background-color: #f1f1f1; margin: 0 auto;"></div>
        @endif

        <div class="text-uppercase my-1" style="font-size: 12px">
            {{ $item->designation ?? "Désignation de l'article" }}
        </div>

        <div class="text-muted" style="font-size: 12px">
            {!! nl2br($item->description) !!}
        </div>
        <div class="d-flex justify-content-between" style="position: relative">
            <div class="text-uppercase text-purple">
                {{ $item->brand->name ?? "Marque" }}
            </div>
            <div class="text-uppercase text-purple">
                {{ $item->provider->name ?? "Fournisseur" }}
            </div>

        </div>

        <div class="d-flex justify-content-between ">
            <div>01</div>
            <div class="text-danger fw-bold">{{ number_format($item->price, 0, '.', ' ') }} CFA</div>
        </div>
    </div>


</div>
