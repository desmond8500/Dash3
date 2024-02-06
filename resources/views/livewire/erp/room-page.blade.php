<div>
    @component('components.layouts.page-header', ['title'=> $room->stage->building->name." : ".$room->stage->name." / ".$room->name , 'breadcrumbs'=>$breadcrumbs])

    @endcomponent

    <div class="row">
        <div class="col-md-7">
            <div class="card mb-2">
                <div class="card-header">
                    <div class="card-title">Articles</div>
                    <div class="card-actions">

                    </div>
                </div>
                <div class="card-body">

                </div>
                <div class="card-footer">

                </div>
            </div>

        </div>
        <div class="col-md-5">
            @livewire('erp.tasklist', ['room' => $room->id], key($room->id))
        </div>
    </div>
</div>
