<div>
    @component('components.layouts.page-header', ['title'=> $room->stage->building->name." : ".$room->stage->name." / ".$room->name , 'breadcrumbs'=>$breadcrumbs])
        @livewire('form.task-add', ['room_id' => $room->id])
    @endcomponent

    <div class="row g-2">
        <div class="col-md-7">
            <div class="card mb-2">
                <div class="card-header">
                    <div class="card-title">{{ $room->name }}</div>
                    <div class="card-actions">
                        <button class="btn btn-primary btn-icon" wire:click="edit('{{ $room->id }}')">
                            <i class="ti ti-edit"></i>
                        </button>
                    </div>
                </div>
            </div>


            <div class="card mb-2">
                <div class="card-header">
                    <div class="card-title">Equipements</div>
                    <div class="card-actions">
                        <button class="btn btn-primary" disabled>
                            <i class="ti ti-plus"></i> Equipement
                        </button>
                    </div>
                </div>
                <div class="card-body">

                </div>
                <div class="card-footer">

                </div>
            </div>

        </div>
        <div class="col-md-5">
            @livewire('erp.tasklist', ['room_id' => $room->id, 'class'=>'col-md-12'])
        </div>
    </div>

    @component('components.modal', ["id"=>'editRoom', 'title' => 'Editer un local'])
        <form class="row" wire:submit="update">
            @include('_form.room_form')
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-editRoom', event => { window.$('#editRoom').modal('show'); }) </script>
        <script> window.addEventListener('close-editRoom', event => { window.$('#editRoom').modal('hide'); }) </script>
    @endcomponent
</div>
