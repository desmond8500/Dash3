<div class="card p-2">
    <div class="row g-2">
        <div class="col-auto">
            <img src="{{ asset("$article->image") }}" alt="A" class="avatar {{ $img_class ?? 'avatar-xl' }}">
        </div>
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
                    <div class="text-muted">
                        @if ($article->brand)
                        {{ $article->brand->name }}
                        @else
                        _
                        @endif
                    </div>
                    <div class="text-muted">
                        @if ($article->provider)
                        <span class="badge bg-blue-lt">{{ $article->provider->name }}</span>
                        @else
                        _
                        @endif
                    </div>
                </div>
                <div class="col-4">
                    <div class="d-flex-between">
                        <div>Qte: </div>
                        <div>{{ $article->quantity }}</div>
                    </div>
                    <div class="d-flex-between">
                        <div>Qte_min: </div>
                        <div>{{ $article->quantity_min }}</div>
                    </div>
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
