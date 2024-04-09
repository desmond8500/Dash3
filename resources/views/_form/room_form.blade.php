<div>
    <div class="row g-2">
        <div class="col-md-3 mb-3">
            <label class="form-label">ID Local</label>
            <input type="text" class="form-control" wire:model="room_form.stage_id" disabled>
            @error('room_form.stage_id') <span class='text-danger'>{{ $message }}</span> @enderror
        </div>

        <div class="col-md-7 mb-3">
            <label class="form-label">Nom du local</label>
            <input type="text" class="form-control" wire:model="room_form.name" placeholder="Nom du niveau">
            @error('room_form.name') <span class='text-danger'>{{ $message }}</span> @enderror
        </div>

        <div class="col-md-2 mb-3">
            <label class="form-label">Odre</label>
            <input type="text" class="form-control" wire:model="room_form.order" placeholder="Odre">
            @error('room_form.order') <span class='text-danger'>{{ $message }}</span> @enderror
        </div>

        <div class="col-md-12 mb-3">
            <label class="form-label">Description</label>
            <textarea class="form-control" wire:model="room_form.description" placeholder="Description" cols="30"
                rows="5"></textarea>
            @error('room_form.description') <span class='text-danger'>{{ $message }}</span> @enderror
        </div>
    </div>
</div>
