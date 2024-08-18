<div class="col-md-2 mb-3">
    <label class="form-label">Zone</label>
    <input type="text" inputmode="numeric" class="form-control" wire:model="zone_form.number" placeholder="Numéro de zone">
    @error('zone_form.number') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-10 mb-3">
    <label class="form-label">Equipement</label>
    <div class="input-group">
        <input type="text" class="form-control" wire:model="zone_form.equipement" placeholder="Equipement">
        <div class="dropdown open">
            <button class="btn btn-secondary btn-icon" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                <i class="ti ti-chevron-down"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="triggerId">
                @foreach ($equipements as $equipement)
                    <a class="dropdown-item" wire:click="set_equipement('{{ $equipement }}')">{{ $equipement }}</a>
                @endforeach
            </div>
        </div>

    </div>
    @error('zone_form.equipement') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="w-100"></div>
<div class="col-md-9 mb-3">
    <label class="form-label">Nom du local</label>
    <div class="input-group">
        <input type="text" class="form-control" wire:model="zone_form.name" placeholder="Nom">
        <div class="dropdown open">
            <button class="btn btn-secondary btn-icon" type="button" id="triggerId" data-bs-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="ti ti-chevron-down"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="triggerId">
                @foreach ($locaux as $local)
                    <a class="dropdown-item" wire:click="set_local('{{ $local }}')">{{ $local }}</a>
                @endforeach
            </div>
        </div>
    </div>
    @error('zone_form.name') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-3 mb-3">
    <label class="form-label">Code</label>
    <input type="text" class="form-control" wire:model="zone_form.code" placeholder="Nom">
    @error('zone_form.code') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-4 mb-3">
    <label class="form-label">Ordre</label>
    <input type="number" class="form-control" wire:model="zone_form.order" >
    @error('zone_form.order') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
