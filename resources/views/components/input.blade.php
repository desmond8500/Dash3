<div class="{{ $class ?? '' }} mb-3">
    @if ($type!='image' && $type!='images')
        <label class="form-label">{{ ucfirst($name ?? 'Name') }}</label>

    @else
        <label for="file" href="#" class="avatar avatar-upload rounded">
            <i class="ti ti-plus"></i>
            <span class="avatar-upload-text">Ajouter</span>
        </label>
    @endif

    @if ($type == 'text' || $type == 'number' || $type == 'password' || $type == 'date')
        <input type="{{ $type ?? 'text' }}" class="form-control" wire:model="{{ $model ?? '' }}" placeholder="{{ $placeholder ?? '' }}">

    @elseif($type =='select')
        <select class="form-control" wire:model="{{ $model ?? '' }}">
            <option value="0" disabled selected>Sélectionner</option>
            @isset ($options)
                @foreach ($options as $item)
                    @isset ($item->id)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @else
                        <option>{{ $item }}</option>
                    @endisset
                @endforeach
            @endisset
        </select>

    @elseif($type =='textarea')
        <textarea class="form-control" wire:model="description" placeholder="{{ $placeholder ?? '' }}" data-bs-toggle="autosize"></textarea>

        @elseif($type =='fileS')
        <input type="file" id="file" multiple style="display: none" wire:model="{{ $model ?? '' }}">

    @elseif($type =='file')
        <input type="file" id="file" style="display: none" wire:model="{{ $model ?? '' }}">

    @elseif($type =='image')
        <input type="file" id="file" accept="image/*" style="display: none" wire:model="{{ $model ?? '' }}">

    @elseif($type =='images')
        <input type="file" id="file" accept="image/*" multiple style="display: none" wire:model="{{ $model ?? '' }}">

    @endif

    @error($model ?? '') <span class='text-danger'>{{ $message }}</span> @enderror
</div>

