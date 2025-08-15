<div class="col-auto mb-3">
    <div wire:loading wire:target='webpage_form.logo'>
        Chargement <div class="spinner-border" role="status"></div>
    </div>
    @if ($webpage_form->logo)
        @if(is_string($webpage_form->logo))
            <img src="{{ $webpage_form->logo }}" alt="" class="avatar avatar-xl rounded avatar-upload">
        @else
            <img src="{{ $webpage_form->logo->temporaryUrl() }}" alt="" class="avatar avatar-xl rounded avatar-upload">
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
    <input type="file" id="file" accept="image/*" style="display: none" wire:model="webpage_form.logo">
</div>

<div class="col-md-6 mb-3">
    <label class="form-label">Catégories</label>
    <select class="form-select" wire:model="webpage_form.webpage_category_id">
        <option value="">- Select-</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select>
    @error('webpage_form.webpage_category_id') <span class='text-danger'>{{ $message }}</span> @enderror
</div>

<div class="col-md-12 mb-3">
    <label class="form-label">Nom</label>
    <input type="text" class="form-control" wire:model="webpage_form.name" placeholder="Nom">
    @error('webpage_form.name') <span class='text-danger'>{{ $message }}</span> @enderror
</div>

<div class="col-md-12 mb-3">
    <label class="form-label">Lien</label>
    <input type="text" class="form-control" wire:model="webpage_form.url" placeholder="Lien">
    @error('webpage_form.url') <span class='text-danger'>{{ $message }}</span> @enderror
</div>

<div class="col-md-12 mb-3">
    <label class="form-label">Description</label>
    <textarea class="form-control" wire:model="webpage_form.description" placeholder="Description" cols="30"
        rows="5"></textarea>
    @error('webpage_form.description') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
