<div class="card p-2">
    <div class="row">
        <div class="col-md-12">
            <a class="card-title text-center" href="{{ route('brand',['brand_id'=>$brand->id]) }}">
                <img src="{{ $brand->logo ? asset($brand->logo) : asset('img/images/not_found.png') }}" alt="{{ $brand->logo }}" class="img-fluid" style="max-height: 100px; margin: auto; display: block;">
            </a>
        </div>
        <div class="col-md-12">
            <a class="card-title text-center" href="{{ route('brand',['brand_id'=>$brand->id]) }}">{{ $brand->name }}</a>
            <div class="text-muted">{!! nl2br($brand->description) !!}</div>
        </div>
        <div class="col-md-12 text-center">
            {{ $brand->article()->count() }}
            @if ($brand->article()->count() > 1)
                Articles
            @else
                Article
            @endif
        </div>
        <div class="dropdown open" style="position: absolute; top: 0; right: 0;">
            <button class="btn btn-action" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                <i class="ti ti-chevron-down"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="triggerId">
                <a class="dropdown-item" wire:click="edit_brand('{{ $brand->id }}')"> <i class="ti ti-edit"></i>
                    Editer</a>
                <a class="dropdown-item" wire:click="edit_logo('{{ $brand->id }}')"> <i class="ti ti-photo-edit"></i>
                    Editer image</a>
                <a class="dropdown-item text-danger" wire:click="delete_brand('{{ $brand->id }}')"> <i class="ti ti-trash"></i>
                    Supprimer</a>
            </div>
        </div>


    </div>
</div>
