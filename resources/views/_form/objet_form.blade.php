<div class="text-start">
    @error('objet_form.id') <span class='text-danger'>{{ $message }}</span> @enderror
    @error('objet_form.installation_id') <span class='text-danger'>{{ $message }}</span> @enderror
    @error('objet_form.parent_id') <span class='text-danger'>{{ $message }}</span> @enderror
    <div class="col-md-12 mb-3">
        <label class="form-label">Nom</label>
        <input type="text" class="form-control" wire:model="objet_form.name" placeholder="Nom">
        @error('objet_form.name') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>
    <div class="col-md-12 mb-3">
        <label class="form-label">Description</label>
        <textarea class="form-control" wire:model="objet_form.description" placeholder="Description" cols="30" rows="5"></textarea>
        @error('objet_form.description') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    {{-- <div class="col-md-4 mb-3">
        <label class="form-label">Video</label>
        <select class="form-select" wire:model="objet_form.name">
            <option value="">Sélectionnez un type</option>
            @foreach($equipements as $equipement)
                <option value="{{ $equipement->name }}">{{ $equipement->description }}</option>
            @endforeach
        </select>
        @error('objet_form.name') <span class='text-danger'>{{ $message }}</span> @enderror
    </div> --}}
    <div class="row">
        <div class="col-md-3">
            <div class="dropdown open">
                <a class="btn" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                    <i class="ti ti-chevron-down"></i>Video
                </a>
                <div class="dropdown-menu" aria-labelledby="triggerId">
                    @foreach ($videos as $video)
                        <div href="" class="dropdown-item" wire:click="$set('objet_form.name', '{{ $video->name }}')">
                            {{ $video->name }}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="dropdown open">
                <button class="btn" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                    <i class="ti ti-chevron-down"></i>Incendie
                </button>
                <div class="dropdown-menu" aria-labelledby="triggerId">
                    @foreach ($incendies as $incendie)
                        <div href="" class="dropdown-item" wire:click="$set('objet_form.name', '{{ $incendie->name }}')">
                            {{ $incendie->name }}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="dropdown open">
                <button class="btn" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                    <i class="ti ti-chevron-down"></i> Accès
                </button>
                <div class="dropdown-menu" aria-labelledby="triggerId">
                    @foreach ($access as $acces)
                        <div href="" class="dropdown-item" wire:click="$set('objet_form.name', '{{ $acces->name }}')">
                            {{ $acces->name }}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="dropdown open">
                <button class="btn" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                    <i class="ti ti-chevron-down"></i> Alarme
                </button>
                <div class="dropdown-menu" aria-labelledby="triggerId">
                    @foreach ($alarmes as $alarme)
                        <div href="" class="dropdown-item" wire:click="$set('objet_form.name', '{{ $alarme->name }}')">
                            {{ $alarme->name }}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

</div>
