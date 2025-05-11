<div>
    @component('components.layouts.page-header', ['title'=> "Types d'articles", 'breadcrumbs'=> $breadcrumbs])
        <div class="btn-list">
            <button class='btn btn-primary' wire:click="$dispatch('open-addType')" ><i class='ti ti-plus'></i> Type</button>

        </div>
    @endcomponent

    <h3>Types</h3>
    <div class="btn-list">

        @foreach ($types as $type)
            <button class="btn " wire:click="select_type('{{ $type }}')">{{ $type }}</button>
        @endforeach
    </div>

    <div class="my-2">
        @foreach ($tags as $tag)
            <span class="badge bg-primary text-light me-1">
                {{ $tag->name }}
                <i class="ti ti-edit cursor-pointer" wire:click="edit_tag('{{ $tag->id }}')"></i>
            </span>
        @endforeach
    </div>


    @component('components.modal', ["id"=>'addType', 'title' => 'Ajouter un type', 'method'=>'store'])
        <form class="row" wire:submit="store" >

            <div class="col-md-12 mb-3">
                <label class="form-label">Nom</label>
                <input type="text" class="form-control" wire:model="name" placeholder="Nom">
                @error('name') <span class='text-danger'>{{ $message }}</span> @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Type</label>
                <select class="form-select" wire:model="type">
                    @foreach ($types as $type)
                        <option>{{ $type }}</option>
                    @endforeach
                </select>
                @error('type') <span class='text-danger'>{{ $message }}</span> @enderror
            </div>

        </form>
        <script> window.addEventListener('open-addType', event => { window.$('#addType').modal('show'); }) </script>
        <script> window.addEventListener('close-addType', event => { window.$('#addType').modal('hide'); }) </script>
    @endcomponent

    @component('components.modal', ["id"=>'editType', 'title' => 'Editer un type', 'method'=>'update'])
        <form class="row" wire:submit="update" >

            <div class="col-md-12 mb-3">
                <label class="form-label">Nom</label>
                <input type="text" class="form-control" wire:model="name" placeholder="Nom">
                @error('name') <span class='text-danger'>{{ $message }}</span> @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Type</label>
                <select class="form-select" wire:model="type">
                    @foreach ($types as $type)
                        <option>{{ $type }}</option>
                    @endforeach
                </select>
                @error('type') <span class='text-danger'>{{ $message }}</span> @enderror
            </div>

        </form>
        <script> window.addEventListener('open-editType', event => { window.$('#editType').modal('show'); }) </script>
        <script> window.addEventListener('close-editType', event => { window.$('#editType').modal('hide'); }) </script>
    @endcomponent

    @component('components.modal', ["id"=>'editTag', 'title' => 'Editer un tag', 'method'=>'update_tag'])
        <form class="row" wire:submit="update_tag" >

            <div class="col-md-12 mb-3">
                <label class="form-label">Nom</label>
                <input type="text" class="form-control" wire:model="tag_name" placeholder="Nom">
                @error('tag_name') <span class='text-danger'>{{ $message }}</span> @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Type</label>
                <select class="form-select" wire:model="tag_type">
                    @foreach ($types as $type)
                        <option>{{ $type }}</option>
                    @endforeach
                </select>
                @error('tag_type') <span class='text-danger'>{{ $message }}</span> @enderror
            </div>

        </form>
        <script> window.addEventListener('open-editTag', event => { window.$('#editTag').modal('show'); }) </script>
        <script> window.addEventListener('close-editTag', event => { window.$('#editTag').modal('hide'); }) </script>
    @endcomponent
</div>
