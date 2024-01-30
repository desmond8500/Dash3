<div>
    @component('components.layouts.page-header', ['title'=>'Gestion de batiment', 'breadcrumbs'=>$breadcrumbs])
        @livewire('form.stage-add', ['building_id' => $building->id], key($building->id))
    @endcomponent

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{ $building->name }}</div>
                    <div class="card-actions">

                    </div>
                </div>
                <div class="card-body">
                    {{ nl2br($building->description) }}
                </div>
                <div class="card-body">
                    <div class="d-grid col-6 gap-2">
                        @foreach ($stages as $stage)
                            <button class="btn btn-primary" type="button">{{ $stage->name }}</button>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="row g-2">
                @foreach ($stages->rooms as $room)

                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">{{ $room-> }}</div>
                            <div class="card-actions">

                            </div>
                        </div>
                        <div class="card-body">

                        </div>
                        <div class="card-footer">

                        </div>
                    </div>

                @endforeach
            </div>
        </div>
    </div>
</div>
