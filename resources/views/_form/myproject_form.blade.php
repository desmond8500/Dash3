<div>
    @error('project_form.user_id') <span class='text-danger'>{{ $message }}</span> @enderror
    <div class="col-auto mb-3">
        <div wire:loading wire:target='project_form.logo'>
            Chargement <div class="spinner-border" role="status"></div>
        </div>
        @if ($project_form->logo)
            @if(is_string($project_form->logo))
                <img src="{{ $project_form->logo }}" alt="" class="avatar avatar-xl rounded avatar-upload">
            @else
                <img src="{{ $project_form->logo->temporaryUrl() }}" alt="" class="avatar avatar-xl rounded avatar-upload">
            @endif
            <label for="file" href="#" class="avatar avatar-xl avatar-upload rounded">
                <i class="ti ti-edit text-muted"></i>
                <span class="avatar-upload-text">Modifier</span>
            </label>
        @else
            <label for="file" href="#" class="avatar avatar-xl avatar-upload rounded">
                <i class="ti ti-plus text-muted"></i>
                <span class="avatar-upload-text">Ajouter</span>
            </label>
        @endif
        <input type="file" id="file" accept="image/*" style="display: none" wire:model="project_form.logo">
    </div>

    <div class="col mb-3">
        <label class="form-label">Nom</label>
        <input type="text" class="form-control" wire:model="project_form.name" placeholder="Nom du projet">
        @error('project_form.name') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="col-md-12 mb-3">
        <label class="form-label">Description</label>
        <textarea class="form-control" wire:model="project_form.description" placeholder="Description du projet" cols="30" rows="5"></textarea>
        @error('project_form.description') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>
</div>
