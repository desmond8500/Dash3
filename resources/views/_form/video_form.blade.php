<div class="col-auto mb-3">
    <div wire:loading wire:target='video_form.preview_image'>
        Chargement <div class="spinner-border" role="status"></div>
    </div>
    @if ($video_form->preview_image)
        @if(is_string($video_form->preview_image))
            <img src="{{ $video_form->preview_image }}" alt="" class="avatar avatar-xl rounded avatar-upload">
        @else
            <img src="{{ $video_form->preview_image->temporaryUrl() }}" alt="" class="avatar avatar-xl rounded avatar-upload">
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
    <input type="file" id="file" accept="image/*" style="display: none" wire:model="video_form.preview_image">
</div>

<div class="col mb-3">
    <label class="form-label">Titre</label>
    <input type="text" class="form-control" wire:model="video_form.title" placeholder="Titre">
    @error('video_form.title') <span class='text-danger'>{{ $message }}</span> @enderror
</div>

<div class="col-md-12 mb-3">
    <label class="form-label">Lien</label>
    <input type="text" class="form-control" wire:model="video_form.url" placeholder="Lien">
    @error('video_form.url') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
