<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Utilisateur</label>
        <select class="form-select" wire:model="user_id">
            <option value="">Sélectionner un utilisateur</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->firstname }} {{ $user->lastname }}</option>
            @endforeach
        </select>
        @error('user_id') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Espace</label>
        <select class="form-select" wire:model="user_space_id">
            <option value="">Sélectionner un espace</option>
            @foreach ($spaces as $space)
                <option value="{{ $space->id }}">{{ $space->name }}</option>
            @endforeach
        </select>
        @error('user_space_id') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Role</label>
        <select class="form-select" wire:model="role">
            <option value="">Sélectionner un rôle</option>
            <option value="Utilisateur" >Utilisateur</option>
            <option value="Administrateur">Administrateur</option>
        </select>
        @error('role') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>


</div>
