<div>
    <div class="mb-1 row g-2">
        <div class="col">
            <h2>Quantitatif</h2>
        </div>
        <div class="col-auto">
            {{-- <div class="btn-list">
                <button class="btn btn-primary" >
                    <i class="ti ti-plus"></i> Quantitatif
                </button> --}}
                <button class="btn btn-icon" wire:click='$refresh'><i class="ti ti-reload"></i> </button>
            {{-- </div> --}}
        </div>
    </div>

    <div class="row g-2">
        <div class="col-md-4">
            <div class="d-grid gap-2">
                @foreach ($quantitatifs as $quantitatif)
                    <div class="btn btn-full" wire:click="select_quantitatif('{{ $quantitatif->id }}')">
                        <div>{{ $quantitatif->name }}</div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-md-8">
            @if ($q_selected)
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Quantitatif</div>
                        <div class="card-actions">
                            <button class="btn btn-primary" >Button</button>
                        </div>
                    </div>
                    <table class="table table-hover">
                        <thead class="sticky-top">
                            <tr>
                                <td class="text-center" width="10px">#</td>
                                <td>Désignation</td>
                                <td class="text-center">Quantité</td>
                                <td class="text-center">Actions</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($q_selected->rows as $key => $row)
                                <tr>
                                    <td class="text-center">{{ $key+1 }}</td>
                                    <td>
                                        <div>{{ $row->article->designation ?? $row->description }}</div>
                                        <div >{{ $row->article->reference ?? 'NA' }}</div>
                                    </td>
                                    <td class="text-center">{{ $row->quantite }}</td>
                                    <td width="100px">
                                        <button class="btn btn-icon btn-primary" wire:click="row_inc({{ $row->id }})"><i class="ti ti-plus"></i></button>
                                        <button class="btn btn-icon btn-primary" wire:click="row_dec({{ $row->id }})"><i class="ti ti-minus"></i></button>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
