<div>
    <div class="mb-1 row g-2">
        <div class="col">
            <h2>Quantitatif</h2>
        </div>
        <div class="col-auto">
            <button class="btn btn-icon" wire:click='$refresh'><i class="ti ti-reload"></i> </button>
        </div>
    </div>

    <div class="row g-2">
        <div class="col-md-4">
            @foreach ($quantitatifs as $quantitatif)
                <div class="card mb-1 p-2" wire:click="select_quantitatif('{{ $quantitatif->id }}')">
                    <div>{{ $quantitatif->name }}</div>
                </div>
            @endforeach
        </div>
        <div class="col-md-8">
            @if ($q_selected)
                <div class="card">
                    <table class="table table-hover">
                        <thead class="sticky-top">
                            <tr>
                                <td class="text-center">#</td>
                                <td>Désignation</td>
                                <td class="text-center">Quantité</td>
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
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
