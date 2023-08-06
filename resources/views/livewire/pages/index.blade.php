<div>
    @component('components.layout.page-header', ['title'=> 'Dashboard', 'breadcrumbs' => []])

    @endcomponent

    <div class="row row-deck g-2">

        <div class="col-md-3">
            <div class="card p-2">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <span class="bg-primary text-white avatar">
                            <i class="ti ti-users"></i>
                        </span>
                    </div>
                    <div class="col">
                        <div class="font-weight-medium">
                            Clients
                        </div>
                        <div class="text-secondary">
                            12 waiting payments
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
