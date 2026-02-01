<div>
    @component('components.layouts.page-header', ['title'=>'Forfaits', 'breadcrumbs'=>$breadcrumbs])
        <div class="btn-list">
            <div class="input-icon">
                <input type="text" class="form-control form-control-rounded" wire:model.live="search" placeholder="Chercher ">
                <span class="input-icon-addon">
                    <i class="ti ti-search"></i>
                </span>
            </div>
            <div class="">
                <select class="form-select">
                    <option value="" wire:click="$set('client_id', '')">Tous</option>
                    @foreach ($clients->sort() as $client)
                        <option value="{{ $client->id }}" wire:click="$set('client_id', '{{ $client->id }}')">{{ $client->name }}</option>
                    @endforeach
                </select>
                @error('Name') <span class='text-danger'>{{ $message }}</span> @enderror
            </div>
            <button class='btn btn-primary' wire:click="$dispatch('open-addForfait')" ><i class='ti ti-plus'></i> Forfait</button>
        </div>
    @endcomponent

    <div class="row row-deck g-2">
        @forelse ($forfaits as $forfait)
            <div class="col-md-4">
                <div class="card p-2">
                    <div class="row">
                        {{-- <div class="col-auto">
                            <img src="" alt="A" class="avatar avatar-md">
                        </div> --}}
                        <div class="col">
                            <div class="badge bg-primary text-white">{{ $forfait->client->name ?? '' }}</div>
                            <div class="card-title">{{ $forfait->designation }}</div>
                            <div class="text-muted">
                                <x-markdown>
                                 {{ $forfait->description }}
                                </x-markdown>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div>
                                <button class="btn btn-outline-primary btn-icon" wire:click="edit('{{ $forfait->id }}')">
                                    <i class="ti ti-edit"></i>
                                </button>
                                <button class="btn btn-outline-danger btn-icon" wire:click="delete('{{ $forfait->id }}')">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </div>
                            <div class="mt-2 fs-3 text-end">{{ number_format($forfait->price, 0,'.', ' ') }} F</div>
                    </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card p-4 text-center">
                    <div class="text-muted">
                        Aucun forfait trouvé. <br>
                        Veuillez sélectionner un autre client ou <a href="#" wire:click="$dispatch('open-addForfait')">ajouter un nouveau forfait</a>.
                    </div>
                </div>
            </div>

        @endforelse
        <div class="card p-2">
            {{ $forfaits->links() }}
        </div>
    </div>

    @component('components.modal', ["id"=>'addForfait', 'title' => 'Ajouter un forfait', 'method'=>'store'])
        <form class="row" wire:submit="store">
            @include('_form.forfait_form')
        </form>
        <script> window.addEventListener('open-addForfait', event => { window.$('#addForfait').modal('show'); }) </script>
        <script> window.addEventListener('close-addForfait', event => { window.$('#addForfait').modal('hide'); }) </script>
    @endcomponent

    @component('components.modal', ["id"=>'editForfait', 'title' => 'Editer un forfait', 'method'=>'update'])
        <form class="row" wire:submit="update">
            @include('_form.forfait_form')
        </form>
        <script> window.addEventListener('open-editForfait', event => { window.$('#editForfait').modal('show'); }) </script>
        <script> window.addEventListener('close-editForfait', event => { window.$('#editForfait').modal('hide'); }) </script>
    @endcomponent
</div>
