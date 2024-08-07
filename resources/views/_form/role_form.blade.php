<div class="col-md-12 mb-3">
    <label class="form-label">Role</label>
    <input type="text" class="form-control" wire:model="role_form.name" placeholder="Role">
    @error('role_form.name') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
