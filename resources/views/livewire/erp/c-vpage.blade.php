<div>
    @component('components.layouts.page-header', ['title'=> 'CV', 'breadcrumbs'=>$breadcrumbs])
        <a class="btn btn-primary" href="{{ route('cv_pdf',['cv_id'=>$cv_id]) }}" target="_blank">PDF</a>
    @endcomponent

    <div class="row">
        <div class="col-md-4">
            <div class="card mb-2">
                <div class="card-header">
                    <div class="card-title">Informations personnelles</div>
                    <div class="card-actions">

                    </div>
                </div>
                <div class="card-body">

                </div>
                <div class="card-footer">

                </div>
            </div>

            <div class="card mb-2">
                <div class="card-header">
                    <div class="card-title">Langues</div>
                    <div class="card-actions">

                    </div>
                </div>
                <div class="card-body">

                </div>
                <div class="card-footer">

                </div>
            </div>

            <div class="card mb-2">
                <div class="card-header">
                    <div class="card-title">Hobbies</div>
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
            <div class="card mb-2">
                <div class="card-header">
                    <div class="card-title">Résumé</div>
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
            <div class="card mb-2">
                <div class="card-header">
                    <div class="card-title">Formations</div>
                    <div class="card-actions">

                    </div>
                </div>
                <div class="card-body">

                </div>
                <div class="card-footer">

                </div>
            </div>

            <div class="card mb-2">
                <div class="card-header">
                    <div class="card-title">Expériences</div>
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
