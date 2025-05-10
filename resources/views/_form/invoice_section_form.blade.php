<div class="col-md-8 mb-3">
    <label class="form-label">Nom de la section</label>
    <input type="text" list="sectionsList" class="form-control" wire:model="section_form.section" placeholder="Nom">
    {{-- <datalist id="sectionsList">
        @foreach ($sections as $section)
            <option value="{{ $section->section }}">{{ $section->section }}</option>
        @endforeach

    </datalist> --}}
    @error('section_form.section') <span class='text-danger'>{{ $message }}</span> @enderror
</div>

<div class="col-md-4 mb-3">
    <label class="form-label">Ordre</label>
    <input type="number" class="form-control" wire:model="section_form.ordre" placeholder="Ordre">
    @error('section_form.ordre') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
