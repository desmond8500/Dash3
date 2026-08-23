<div class="row">
    @php
    $total = 0;
    @endphp

    <div class="col-md-6">
        <div class="card mb-2">
            <div class="card-header">
                <div class="card-title">Stock à faire</div>
                <div class="card-actions">
                    <button class="btn btn-icon" wire:click='$refresh'><i class="ti ti-reload"></i> </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-2">
                    @foreach ($articles as $article)
                    <div class="col-md-6">
                        @include('_card.articleCard',[
                        'img_class' => ''
                        ])
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="card-footer">
                {{ $articles->links() }}
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card mb-2">
            <div class="card-header">
                <div class="card-title">Commandes à faire</div>
                <div class="card-actions">
                    <a class="btn btn-primary" href="{{ route('commande_pdf') }}" target="_blank">PDF</a>
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Photo</th>
                        <th>Désignation</th>
                        <th>Fournisseur</th>
                        <th class="text-center">Qte</th>
                        <th class="text-end">Prix</th>
                        <th class="text-end">Total</th>
                        {{-- <th class="text-center" width="100px">Actions</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($commands as $key => $command)
                    <tr>
                        <td width="10px">{{ $key +1 }}</td>
                        <td width="10px">
                            <img src="{{ asset($command->article->image) }}" alt="" class="avatar p-1 me-1"
                                style="object-fit: cover">
                        </td>
                        <td class="">
                            <a href="{{ route('article',['article_id'=>$command->article->id ]) }}" target="_blank">
                                <div>
                                    <div>{{ $command->article->designation }}</div>
                                    <div class="text-muted">{{ $command->article->reference }}</div>
                                </div>
                            </a>
                        </td>
                        <td>
                            <div>{{ $command->article->provider->name ?? '-' }}</div>
                            <div>{{ $command->article->brand->name ?? '-' }}</div>
                        </td>
                        <td class="text-center" width="10px">{{ $command->total_quantity }}</td>
                        <td class="text-end">{{ number_format($command->article->price,0,2) }} CFA</td>
                        <td class="text-end">{{ number_format($command->article->price * $command->total_quantity,0,2) }}
                            CFA</td>
                        {{-- <td class="text-center">
                            <button class="btn btn-icon btn-primary" wire:click="increment('{{ $command->id }}')"> <i
                                    class="ti ti-plus"></i> </button>
                            <button class="btn btn-icon btn-primary" wire:click="decrement('{{ $command->id }}')"> <i
                                    class="ti ti-minus"></i> </button>
                        </td> --}}
                    </tr>
                    @php
                    $total+= $command->article->price * $command->quantity;
                    @endphp
                    @endforeach
                </tbody>
            </table>
            <div class="card-body">
                <b>TOTAL :</b> <span>{{ number_format($total,0,2) }}</span>
            </div>
        </div>
    </div>
</div>
