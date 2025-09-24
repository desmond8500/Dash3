<div>
    <div class="col-auto mb-3">
        <div wire:loading wire:target='document_form.path'>
            Chargement <div class="spinner-border" role="status"></div>
        </div>
        @if ($document_form->path)
            @if(is_string($document_form->path))
                <img src="{{ $document_form->path }}" alt="" class="avatar avatar-xl rounded avatar-upload">
            @else
                @if ($document_form->path && in_array($document_form->path->getMimeType(), ['application/pdf']))
                    {{-- <iframe src="{{ $document_form->path->temporaryUrl() }}" class="w-full h-96"></iframe> --}}
                @else
                    <img src="{{ $document_form->path->temporaryUrl() ?? ''}}" alt="" class="avatar avatar-xl rounded avatar-upload">

                @endif
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
        <input type="file" id="file"  style="display: none" wire:model="document_form.path">
    </div>

    <div class="col-md-12 mb-3">
        <label class="form-label">Nom du document</label>
        <input type="text" class="form-control" wire:model="document_form.name" placeholder="Nom du document">
        @error('document_form.name') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>
</div>
