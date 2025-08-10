<div>
    <div class="dropdown">
        <div type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >

        @if ($status=="Nouveau")
            <div class="{{ $type ?? 'status status' }}-primary w-100" style="font-size:11px;">
                <span class="status-dot"></span>
                {{ $status }}
            </div>
            @elseif ($status=="En Cours")
            <div class="{{ $type ?? 'status status' }}-warning w-100" style="font-size:11px;">
                <span class="status-dot"></span>
                {{ $status }}
            </div>
            @elseif ($status=="En Pause")
            <div class="{{ $type ?? 'status status' }}-danger w-100" style="font-size:11px;">
                <span class="status-dot"></span>
                {{ $status }}
            </div>
            @elseif ($status=="Annulé")
            <div class="{{ $type ?? 'status status' }}-vk w-100" style="font-size:11px;">
                <span class="status-dot"></span>
                {{ $status }}
            </div>
            @elseif ($status=="Bl a faire")
            <div class="{{ $type ?? 'status status' }}-blue w-100" style="font-size:11px;">
                <span class="status-dot"></span>
                {{ $status }}
            </div>
            @elseif ($status=="A Facturer")
            <div class="{{ $type ?? 'status status' }}-rss w-100" style="font-size:11px;">
                <span class="status-dot"></span>
                {{ $status }}
            </div>
            @elseif ($status=="Terminé")
            <div class="{{ $type ?? 'status status' }}-success w-100" style="font-size:11px;">
                <span class="status-dot"></span>
                {{ $status }}
            </div>
            @elseif ($status=="Proforma")
            <div class="{{ $type ?? 'status status' }}-purple w-100" style="font-size:11px;">
                <span class="status-dot"></span>
                {{ $status }}
            </div>
            @else
            <div class="{{ $type ?? 'status status' }}-{{ $color ?? '' }}" style="font-size:11px;">
                <span class="status-dot"></span>
                {{ $status ?? '' }}
            </div>
            @endif

        </div>
        <div class="dropdown-menu" aria-labelledby="triggerId">
            @foreach ($statuses as $status)
                @isset($invoice_id)
                    <a class="dropdown-item" wire:click="update_status('{{ $invoice_id }}','{{ $status }}')">{{ $status }}</a>
                @endisset
                @isset($devis->id)
                    <a class="dropdown-item" wire:click="update_status('{{ $devis->id }}','{{ $status }}')">{{ $status }}</a>
                @endisset
            @endforeach
        </div>
    </div>

</div>
