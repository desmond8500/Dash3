<div class="col-md-12 mb-3">
    <label class="form-label">Permission</label>
    <input type="text" class="form-control" wire:model="permission_form.name" placeholder="Permission">
    @error('permission_form.name') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
