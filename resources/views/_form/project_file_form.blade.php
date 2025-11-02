@if ($type =='fichiers')
    <div class="col-auto mb-3">
        <div wire:loading wire:target='clientForm.avatar'>
            Chargement <div class="spinner-border" role="status"></div>
        </div>

        @if ($files)
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
        <input type="file" id="file" multiple style="display: none" wire:model="files">
    </div>
@else
    <div class="col-auto mb-3">
        <div wire:loading wire:target='clientForm.avatar'>
            Chargement <div class="spinner-border" role="status"></div>
        </div>
        @if ($files)
            @if(is_string($files))
                <img src="{{ $files }}" alt="" class="avatar avatar-xl rounded avatar-upload">
            @else
                @foreach ($files as $file)
                    <img src="{{ $file->temporaryUrl() }}" alt="" class="avatar avatar-xl rounded avatar-upload">
                @endforeach
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
        <input type="file" id="file" accept="image/*" multiple style="display: none" wire:model="files">
    </div>
@endif
