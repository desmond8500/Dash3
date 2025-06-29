<div class="col-auto mb-3">
    <div wire:loading wire:target='form.name'>
        Chargement <div class="spinner-border" role="status"></div>
    </div>

    @if ($form->name)
        @foreach ($form->name as $avatar)

            @if(is_string($avatar))
                <img src="{{ $avatar }}" alt="" class="avatar avatar-xl mb-1 rounded avatar-upload">
            @else
                <img src="{{ $avatar->temporaryUrl() }}" alt="" class="avatar avatar-xl mb-1 rounded avatar-upload">
            @endif

        @endforeach

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
    <input type="file" id="file" accept="image/*" multiple style="display: none" wire:model.live="form.name">
</div>
