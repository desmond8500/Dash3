<div class="card p-2">
    <div class="row g-2">
        @if($card_type==3)
            <div class="col-md-12">
                <img src="{{ asset($brand->logo) ?? 'https://avatar.iran.liara.run/public' }}" alt="M" class="img-fluid">
            </div>
            <div class="col-md-12">
                <a class="card-title text-center" href="{{ route('brand',['brand_id'=>$brand->id]) }}">{{ $brand->name }}</a>
                <div class="text-muted">{!! nl2br($brand->description) !!}</div>
            </div>
        @else
            <div class="col-auto">
                <img src="{{ asset($brand->logo) ?? 'https://avatar.iran.liara.run/public' }}" alt="M"
                    class="avatar avatar-md">
            </div>
            <div class="col">
                <a class="card-title" href="{{ route('brand',['brand_id'=>$brand->id]) }}">{{ $brand->name }}</a>
                <div class="text-muted">{!! nl2br($brand->description) !!}</div>
            </div>
            <div class="col-auto">
                <div class="dropdown open">
                    <button class="btn btn-action" type="button" id="triggerId" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="ti ti-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="triggerId">
                        <a class="dropdown-item" wire:click="edit_brand('{{ $brand->id }}')"> <i class="ti ti-edit"></i>
                            Editer</a>
                        <a class="dropdown-item" wire:click="edit_logo('{{ $brand->id }}')"> <i class="ti ti-edit"></i>
                            Editer image</a>
                        <a class="dropdown-item text-danger" wire:click="delete_brand('{{ $brand->id }}')"> <i
                                class="ti ti-trash"></i> Supprimer</a>
                    </div>
                </div>

            </div>
        @endif
    </div>
</div>
