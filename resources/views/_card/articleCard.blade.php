<div class="card p-2">
    <div class="row">
        <div class="col-auto">
            <img src="{{ asset("storage/$article->image") }}" alt="A" class="avatar avatar-xl">
        </div>
        <div class="col">
            <div class="row">
                <div class="col">
                    <a class="fw-bold" href="{{ route('article',['article_id'=>$article->id]) }}">{{ $article->designation }}</a>
                </div>
                <div class="col-auto">
                    <button class="btn btn-outline-primary btn-icon" wire:click="edit('{{ $article->id }}')">
                        <i class="ti ti-edit"></i>
                    </button>
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
                    {{ $article->provider->name }}
                @else
                    _
                @endif
            </div>
            <div class="text-muted">{!! nl2br($article->description) !!}</div>

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
