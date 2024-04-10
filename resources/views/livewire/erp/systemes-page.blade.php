<div>
    @component('components.layouts.page-header', ['title'=>'Systèmes', 'breadcrumbs'=>$breadcrumbs])
        <div class="btn-list">
            @livewire('form.systeme-add')

        </div>
    @endcomponent

    @foreach ($systemes as $systeme)
        <div class="btn-group">
            <button class="btn" >{{ $systeme->name}}</button>
            <button class="btn btn-outline-primary btn-icon" wire:click="edit('{{ $systeme->id }}')">
                <i class="ti ti-edit"></i>
            </button>
            <button class="btn btn-outline-danger btn-icon" wire:click="delete('{{ $systeme->id }}')" wire:confirm='Etes vous sure de vouloir supprimer ce système ?'>
                <i class="ti ti-trash"></i>
            </button>
        </div>
    @endforeach

    @component('components.modal', ["id"=>'editSysteme', 'title' => 'Editer le système'])
        <form class="row" wire:submit="update">
            @include('_form.systeme_form')
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-editSysteme', event => { $('#editSysteme').modal('show'); }) </script>
        <script> window.addEventListener('close-editSysteme', event => { $('#editSysteme').modal('hide'); }) </script>
    @endcomponent

</div>
