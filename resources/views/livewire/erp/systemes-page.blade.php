<div>
    @component('components.layouts.page-header', ['title'=>'Systèmes', 'breadcrumbs'=>$breadcrumbs])
        <div class="btn-list">
            @livewire('form.systeme-add')

        </div>
    @endcomponent



    <div class="row g-2">
        @foreach ($systemes as $systeme)
            <div class="col-auto">
                <div class="btn-group">
                    <button class="btn" >{{ $systeme->name}}</button>
                    <button class="btn btn-outline-primary btn-icon" wire:click="edit('{{ $systeme->id }}')">
                        <i class="ti ti-edit"></i>
                    </button>
                    <button class="btn btn-outline-danger btn-icon" wire:click="delete('{{ $systeme->id }}')" wire:confirm='Etes vous sure de vouloir supprimer ce système ?'>
                        <i class="ti ti-trash"></i>
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    @component('components.modal', ["id"=>'editSysteme', 'title' => 'Editer le système', 'method'=>'update'])
        <form class="row" wire:submit="update">
            @include('_form.systeme_form')
        </form>
        <script> window.addEventListener('open-editSysteme', event => { window.$('#editSysteme').modal('show'); }) </script>
        <script> window.addEventListener('close-editSysteme', event => { window.$('#editSysteme').modal('hide'); }) </script>
    @endcomponent

</div>
