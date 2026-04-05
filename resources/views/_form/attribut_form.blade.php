<div>
    <div class="col-md-12 mb-3">
        <label class="form-label">Nom</label>
        <div class="input-group">
            <input type="text" class="form-control" wire:model="attribut_name" placeholder="Nom">
            <div class="dropdown open">
                <button class="btn btn-primary" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                    <i class="ti ti-chevron-down"></i> Réseaux
                </button>
                <div class="dropdown-menu" aria-labelledby="triggerId">
                    @foreach ($reseaux as $reseau)
                        <a class="dropdown-item" wire:click="set('attribut_name', '{{ $reseau->name }}')"> {{ $reseau->name }}</a>
                    @endforeach
                </div>
            </div>

        </div>
        @error('attribut_name') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Valeur</label>
        <input type="text" class="form-control" wire:model="attribut_value" placeholder="Valeur">
        @error('attribut_value') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>
</div>
