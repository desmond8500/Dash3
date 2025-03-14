<div>
    @component('components.layouts.page-header', ['title'=> 'Documents', 'breadcrumbs'=> $breadcrumbs])

    @endcomponent

    <div class="row g-2">
        <div class="col-md-4">
            <div class="card mb-2">
                <div class="card-header">
                    <div class="card-title">Documents</div>
                    <div class="card-actions">

                    </div>
                </div>
            </div>
            @foreach ($fiches as $fiche)
                <a class="card p-2 mb-1" href="{{ route($fiche->route,['name'=> $fiche->name, 'type'=> $fiche->type]) }}" target="_blank">
                    <div class="d-flex-between">
                        <div>{{ $fiche->name }}</div>
                        <i class="ti ti-download"></i>
                    </div>
                </a>
            @endforeach

            {{-- <div>{{ $fiches->links() }}</div> --}}

        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Documents</div>
                    <div class="card-actions">

                    </div>
                </div>
                <div class="card-body">

                </div>
                <div class="card-footer">

                </div>
            </div>
        </div>
    </div>
</div>
