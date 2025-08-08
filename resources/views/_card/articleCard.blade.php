<div class="card p-2">
    <div class="row g-2">
        <a class="col-auto" href="{{ route('article',['article_id'=>$article->id]) }}" >
            <img src="{{ asset($article->image) }}" alt="A" class="avatar p-1 bg-white {{ $img_class ?? 'avatar-xl' }}" style="object-fit: contain;" >
        </a>
        <div class="col">
            <div class="row">
                <div class="col">
                    <div style="min-height: 20px; max-height: 40px; overflow:hidden">
                        <a class="fw-bold" href="{{ route('article',['article_id'=>$article->id]) }}" wire:navigate>{{ $article->designation }}</a>
                    </div>
                </div>
                @isset($edit)
                    <div class="col-auto">
                        <button class="btn btn-ghost-primary btn-icon" id="triggerId" data-bs-toggle="dropdown" >
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

                @isset($form)
                    <div class="col-auto">
                        {{-- <div class="input-group">
                            <input type="text" class="form-control form-control-sm" wire:model="quantity" placeholder="Name"> --}}
                            <button class="btn btn-primary btn-icon" wire:click="$dispatch('generateArticleRow', { article_id: {{ $article->id }}})">
                                <i class="ti ti-plus"></i>
                            </button>
                                {{-- @error('Name') <span class='text-danger'>{{ $message }}</span> @enderror
                        </div> --}}
                    </div>
                @endisset
            </div>
            @isset ($img_class)
                </div>
                <div class="col-12">
            @endisset
            <div class="row">
                <div class="col-8">
                    <div class="text-muted" data-bs-toggle="tooltip" title="Réference" style="font-size:10px">
                        {{ strtoupper($article->reference) }}
                    </div>
                    <div class="text-muted" data-bs-toggle="tooltip" title="Marque">
                        @if ($article->brand)
                        <a href="{{ route('brand', ['brand_id'=>$article->brand->id]) }}" target="_blank" class="text-muted">{{ $article->brand->name }}</a>
                        @else
                        _
                        @endif
                    </div>
                    <div class="text-muted" data-bs-toggle="tooltip" title="Fournisseur" style="font-size:12px">
                        @if ($article->provider)
                        <a href="{{ route('provider', ['provider_id'=>$article->provider_id]) }}" target="_blank" class="badge bg-blue-lt">{{ $article->provider->name }}</a>
                        @else
                        _
                        @endif
                    </div>
                </div>
                <div class="col-4">
                    <div class="me-2">
                        <div class="text-end mt-2" style="font-size: 20px" data-bs-toggle="tooltip" title="Quantité">{{ $article->quantity }}</div>
                    </div>
                </div>
            </div>

            <div class="row mt-1">
                <div class="col-6">
                    <div class="badge " style="font-size:10px" data-bs-toggle="tooltip" title="Priorité">{{ $article->priority() }}</div>
                </div>
                <div class="col-6">
                    <div class="text-danger text-end" style="font-size: 18px">{{ number_format($article->price, 0, 2) }} F</div>
                </div>
            </div>
        </div>
    </div>
</div>
