<div>
    @component('components.layouts.page-header', ['title'=> $stage->building->name.": ".$stage->name , 'breadcrumbs'=>$breadcrumbs])

    @endcomponent
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <div class="fw-bold">Local</div>
                    </div>
                    <div class="card-actions">
                        <div>{{ $stage->name }}</div>
                    </div>
                </div>
                <div class="card-body">
                    {{ nl2br($stage->description) }}
                </div>
                <div class="card-footer">

                </div>
            </div>

        </div>

        <div class="col-md-4">
            <div class="card">
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

        <div class="col-md-4">
            @livewire('erp.tasklist', ['stage_id' => $stage->id], key($stage->id))
        </div>
    </div>
</div>
