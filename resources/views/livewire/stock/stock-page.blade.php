<div>
    @component('components.layouts.page-header', ['title'=>'Stock', 'breadcrumbs'=>$breadcrumbs])

    @endcomponent


    <div class="row mt-2 g-2">
        @foreach ($sections as $section)
            <a class="col-md-3" href="{{ route($section['route']) }}">
                <div class="card p-2">
                    <div class="row">
                        <div class="col-auto">
                            <img src="" alt="A" class="avatar avatar-md">
                        </div>
                        <div class="col">
                            <div class="fw-bold">{{ $section['name'] }}</div>
                            <div class="text-muted">Description</div>
                        </div>
                        <div class="col-auto">

                      </div>
                    </div>
                </div>
            </a>
        @endforeach
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Articles à acheter</div>
                    <div class="card-actions">

                    </div>
                </div>
                <div class="card-body">

                </div>
            </div>
        </div>
    </div>

</div>
