<div>
    @error('cv_form.user_id') <span class='text-danger'>{{ $message }}</span> @enderror

    <div class="col-md-12 mb-3">
        <label class="form-label">Nom</label>
        <input type="text" class="form-control" wire:model="cv_form.name" placeholder="Nom">
        @error('cv_form.name') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>
</div>
