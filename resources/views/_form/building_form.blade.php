<div>
    <div class="row">
        <div class="col-md-9 mb-3">
            <label class="form-label">Nom du batiment</label>
            <div class="input-group ">
                <input type="text" class="form-control" wire:model="building_form.name" placeholder="Nom du batiment">
                <div class="dropdown open">
                    <button class="btn btn-primary btn-icon" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                        <i class="ti ti-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="triggerId">
                        <a class="dropdown-item" wire:click="set('building_form.name', 'Batiment')">  Batiment</a>
                        <a class="dropdown-item" wire:click="set('building_form.name', 'Agence')">  Agence</a>
                        <a class="dropdown-item" wire:click="set('building_form.name', 'Restaurant')">  Restaurant</a>
                        <a class="dropdown-item" wire:click="set('building_form.name', 'Maison')">  Maison</a>
                        <a class="dropdown-item" wire:click="set('building_form.name', 'Villa')">  Villa</a>
                    </div>
                </div>
            </div>
            @error('building_form.name') <span class='text-danger'>{{ $message }}</span> @enderror
        </div>
        <div class="col-md-3 mb-3">
            <label class="form-label">Ordre</label>
            <input type="number" class="form-control" wire:model="building_form.order" placeholder="Odre">
            @error('building_form.order') <span class='text-danger'>{{ $message }}</span> @enderror
        </div>

        <div class="col-md-12 mb-3">
            <label class="form-label">Description</label>
            <textarea class="form-control" wire:model="building_form.description" placeholder="Description" data-bs-toggle="autosize"></textarea>
            @error('building_form.description') <span class='text-danger'>{{ $message }}</span> @enderror
        </div>
    </div>
</div>
