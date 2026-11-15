<div>
    @component('components.layouts.page-header', ['title'=>'Icônes', 'breadcrumbs'=>$breadcrumbs])
        <div class="btn-list">
            <div>
                <input type="text" class="form-control form-control-rounded" wire:model.live="search" placeholder="Chercher une icône">
            </div>
            <button class="btn btn-primary" wire:click="add_icon"><i class="ti ti-plus"></i> Icône</button>
        </div>
    @endcomponent

    <div class="alert alert-info">
        Une icône est liée aux articles portant son tag. Les équipements liés à ces articles l'utilisent sur les plans.
    </div>

    <div class="row row-deck g-2">
        @forelse ($icons as $icon)
            <div wire:key="icon-{{ $icon->id }}" class="col-6 col-md-3 col-lg-2">
                <div class="card">
                    <div class="card-body text-center">
                        @if ($icon->image)
                            <span class="avatar avatar-lg rounded-circle mb-2" style="background-image: url({{ asset($icon->image) }})"></span>
                        @else
                            <span class="avatar avatar-lg rounded-circle mb-2 text-white" style="background: {{ $icon->color ?? '#1690b7' }}">
                                <i class="ti {{ $icon->tabler ?? 'ti-map-pin' }}" style="font-size: 1.6rem"></i>
                            </span>
                        @endif
                        <div class="fw-bold text-truncate">{{ $icon->name }}</div>
                        <div class="small">
                            @if ($icon->tag)
                                <span class="badge bg-azure-lt"><i class="ti ti-tag"></i> {{ $icon->tag }}</span>
                            @else
                                <span class="text-secondary">Sans tag</span>
                            @endif
                        </div>
                        <div class="small text-secondary mt-1"><code>{{ $icon->tabler ?? '—' }}</code></div>
                    </div>
                    <div class="card-footer p-2 d-flex justify-content-center btn-list">
                        <button class="btn btn-sm btn-icon" title="Image" wire:click="edit_image({{ $icon->id }})"><i class="ti ti-photo"></i></button>
                        <button class="btn btn-sm btn-icon" title="Modifier" wire:click="edit_icon({{ $icon->id }})"><i class="ti ti-edit"></i></button>
                        <button class="btn btn-sm btn-icon text-danger" title="Supprimer" wire:click="delete_icon({{ $icon->id }})"
                            wire:confirm="Supprimer l'icône « {{ $icon->name }} » ?"><i class="ti ti-trash"></i></button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card card-body text-center text-secondary">Aucune icône.</div>
            </div>
        @endforelse
    </div>

    @component('components.modal', ["id"=>'editIcon', 'title' => 'Icône', 'method'=>'save_icon'])
        <form class="row" wire:submit="save_icon">
            <div class="col-md-6 mb-3">
                <label class="form-label required">Nom</label>
                <input type="text" class="form-control" wire:model="name" placeholder="Caméra dôme">
                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Tag d'article</label>
                <input type="text" class="form-control" wire:model="tag" list="icon-tags" placeholder="Caméra">
                <datalist id="icon-tags">
                    @foreach ($tags as $t)
                        <option value="{{ $t }}"></option>
                    @endforeach
                </datalist>
            </div>
            <div class="col-md-8 mb-3">
                <label class="form-label">Icône Tabler</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="ti {{ $tabler ?: 'ti-map-pin' }}"></i></span>
                    <input type="text" class="form-control" wire:model.live.debounce.500ms="tabler" placeholder="ti-device-cctv">
                </div>
                @error('tabler') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Couleur</label>
                <input type="color" class="form-control form-control-color w-100" wire:model="color">
            </div>
        </form>
        @script
            <script> window.addEventListener('open-editIcon', event => { window.$('#editIcon').modal('show'); }) </script>
            <script> window.addEventListener('close-editIcon', event => { window.$('#editIcon').modal('hide'); }) </script>
        @endscript
    @endcomponent

    @component('components.modal', ["id"=>'editIconImage', 'title' => "Image de l'icône", 'method'=>'update_image'])
        <form class="" wire:submit="update_image">
            <div class="text-center mb-3">
                <div wire:loading wire:target='image'>
                    Chargement <div class="spinner-border" role="status"></div>
                </div>
                <div class="my-2">
                    @if ($image)
                        <img src="{{ $image->temporaryUrl() }}" class="avatar avatar-xl">
                    @else
                        <input type="file" class="form-control" accept="image/*" wire:model='image'>
                    @endif
                </div>
                @error('image') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </form>
        @script
            <script> window.addEventListener('open-editIconImage', event => { window.$('#editIconImage').modal('show'); }) </script>
            <script> window.addEventListener('close-editIconImage', event => { window.$('#editIconImage').modal('hide'); }) </script>
        @endscript
    @endcomponent
</div>
