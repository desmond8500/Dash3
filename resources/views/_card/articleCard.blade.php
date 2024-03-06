<div class="card p-2">
    <div class="row g-2">
        <div class="col-auto">
            <img src="{{ asset("storage/$article->image") }}" alt="A" class="avatar avatar-xl">
        </div>
        <div class="col">
            <div class="row">
                <div class="col">
                    <a class="fw-bold" href="{{ route('article',['article_id'=>$article->id]) }}">{{ $article->designation }}</a>
                </div>
                <div class="col-auto">
                    <button class="btn btn-outline-primary btn-icon"
                        id="triggerId"
                        data-bs-toggle="dropdown"
                        >
                        <i class="ti ti-dots-vertical"></i>
                    </button>

                    <div class="dropdown-menu dropdown-menu-start" aria-labelledby="triggerId" >
                        <a class="dropdown-item" wire:click="edit('{{ $article->id }}')">Editer</a>
                        <a class="dropdown-item" wire:click="dupliquer('{{ $article->id }}')">Dupliquer</a>
                        <a class="dropdown-item" wire:click="buy('{{ $article->id }}')">Commander</a>
                        {{-- <div class="dropdown-divider"></div> --}}
                        {{-- <a class="dropdown-item" href="#" disabled>Action</a> --}}
                    </div>
                </div>
            </div>

            <div class="text-muted" >
                @if ($article->brand)
                    {{ $article->brand->name }}
                @else
                    _
                @endif
            </div>
            <div class="text-muted" >
                @if ($article->provider)
                    <span class="badge bg-blue-lt">{{ $article->provider->name }}</span>
                @else
                    _
                @endif
            </div>
            {{-- <div class="text-muted">{!! nl2br($article->description) !!}</div> --}}

            <div class="row mt-1">
                <div class="col-md-6">
                    <div class="badge">{{ $article->priority() }}</div>
                </div>
                <div class="col-md-6">
                    <div class="text-danger text-end" style="font-size: 20px">{{ number_format($article->price, 0, 2) }} F</div>
                </div>
            </div>
        </div>
        <div class="col-auto">
        </div>
    </div>
</div>
