<div class="card p-2" >
    <div class="row g-2">
        <div class="col-auto">
            <img src="{{ asset($article->image) }}" class="avatar avatar-md" alt="">
        </div>
        <div class="col">
            <div class="text-uppercase my-1" style="font-size: 12px">
                {{ $article->designation ?? "Désignation de l'article" }}
            </div>

            <div class="text-muted" style="font-size: 12px;">
                {{ $article->description ?? "Description de l'article" }}
            </div>


        </div>
        <div class="col-auto">
            <div class="dropdown open">
                <button class="btn btn-action" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                    <i class="ti ti-chevron-down"></i>
                </button>
                <div class="dropdown-menu" aria-labelledby="triggerId">
                    <a class="dropdown-item" > <i class="ti ti-edit"></i> Editer</a>
                    <a class="dropdown-item text-danger" > <i class="ti ti-trash"></i> Supprimer</a>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div style="font-size: 12px" class="d-flex">
                <div class="text-uppercase text-primary"> {{ $article->provider->name ?? "Fournisseur" }} / </div>
                <div class="text-uppercase text-primary ms-1"> {{ $article->brand->name ?? "Marque" }} </div>
            </div>
            <div class="text-end"> {{ number_format($article->price, 0, 0) ?? "120 000" }} CFA</div>
        </div>
        {{-- <div class="col-6">
            <div class="col-md-12 mb-3">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" wire:model="Name" placeholder="Name">
                @error('Name') <span class='text-danger'>{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="col-6">
            <button class="btn btn-primary" >Button</button>
        </div> --}}

    </div>

</div>
