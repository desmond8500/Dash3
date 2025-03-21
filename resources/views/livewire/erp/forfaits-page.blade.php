<div>
    @component('components.layouts.page-header', ['title'=>'Forfaits', 'breadcrumbs'=>$breadcrumbs])
        <button class='btn btn-primary' wire:click="$dispatch('open-addForfait')" ><i class='ti ti-plus'></i> Forfait</button>
    @endcomponent

    <div class="row g-2">
        @foreach ($forfaits as $forfait)
            <div class="col-md-4">
                <div class="card p-2">
                    <div class="row">
                        {{-- <div class="col-auto">
                            <img src="" alt="A" class="avatar avatar-md">
                        </div> --}}
                        <div class="col">
                            <div class="card-title">{{ $forfait->designation }}</div>
                            <div class="text-muted">@parsedown($forfait->description)</div>
                        </div>
                        <div class="col-auto">
                        <button class="btn btn-outline-primary btn-icon" wire:click="edit('{{ $forfait->id }}')">
                            <i class="ti ti-edit"></i>
                        </button>
                        <button class="btn btn-outline-danger btn-icon" wire:click="delete('{{ $forfait->id }}')">
                            <i class="ti ti-trash"></i>
                        </button>
                    </div>
                    </div>
                </div>

            </div>
        @endforeach
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
