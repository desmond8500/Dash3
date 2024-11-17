<div class="card p-2">
    <div class="row g-2">
        <a class="col-auto" href="{{ route('article',['article_id'=>$article->id]) }}">
            <img src="{{ asset("$article->image") }}" alt="A" class="avatar {{ $img_class ?? 'avatar-xl' }}">
        </a>
        <div class="col">
            <div class="row">
                <div class="col">
                    <a class="fw-bold" href="{{ route('article',['article_id'=>$article->id]) }}">{{ $article->designation }}</a>
                </div>
                @isset($edit)
                    <div class="col-auto">
                        <button class="btn btn-outline-primary btn-icon" id="triggerId" data-bs-toggle="dropdown" >
                            <i class="ti ti-dots-vertical"></i>
                        </button>

                        <div class="dropdown-menu dropdown-menu-start" aria-labelledby="triggerId" >
                            <a class="dropdown-item" wire:click="edit('{{ $article->id }}')"><i class="ti ti-edit"></i> Editer</a>
                            <a class="dropdown-item" wire:click="dupliquer('{{ $article->id }}')"><i class="ti ti-copy"></i> Dupliquer</a>
                            <a class="dropdown-item" wire:click="buy('{{ $article->id }}')"><i class="ti ti-shopping-cart"></i> Commander</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger" wire:click="delete('{{ $article->id }}')" > <i class="ti ti-trash"></i> Supprimer</a>
                        </div>
                    </div>

                @endisset
            </div>
            @isset ($img_class)
                </div>
                <div class="col-12">
            @endisset
            <div class="row">
                <div class="col-8">
                    <div class="text-muted" data-bs-toggle="tooltip" title="Marque">
                        @if ($article->brand)
                        <a href="{{ route('brand', ['brand_id'=>$article->brand->id]) }}" target="_blank" class="text-muted">{{ $article->brand->name }}</a>
                        @else
                        _
                        @endif
                    </div>
                    <div class="text-muted" data-bs-toggle="tooltip" title="Fournisseur">
                        @if ($article->provider)
                        <a href="{{ route('provider', ['provider_id'=>$article->provider_id]) }}" target="_blank" class="badge bg-blue-lt">{{ $article->provider->name }}</a>
                        @else
                        _
                        @endif
                    </div>
                </div>
                <div class="col-4">
                    <div class="text-end mt-2" style="font-size: 20px" data-bs-toggle="tooltip" title="Quantité">{{ $article->quantity }}</div>
                </div>
            </div>

            <div class="row mt-1">
                <div class="col-md-6">
                    <div class="badge">{{ $article->priority() }}</div>
                </div>
                <div class="col-md-6">
                    <div class="text-danger text-end" style="font-size: 20px">{{ number_format($article->price, 0, 2) }} F</div>
                </div>
            </div>
        </div>
    </div>
</div>
