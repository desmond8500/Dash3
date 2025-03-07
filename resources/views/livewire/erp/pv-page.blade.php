<div>
    @component('components.layouts.page-header', ['title'=>'Procès verbal', 'breadcrumbs'=>$breadcrumbs])
        <a href="{{ route("pv_pdf",['invoice_id'=> $invoice_id]) }}" target="_blank" class="btn btn-primary" >PDF</a>
    @endcomponent

    <div class="row">
        <div class="col-md-4">

            <div class="card">
                <div class="card-header">
                    <div class="card-title"></div>
                    <div class="card-actions">
                        <button class="btn btn-primary btn-icon">
                            <i class="ti ti-edit"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">

                    @include('_form.pv_form')

                </div>
                <div class="card-footer">

                </div>
            </div>

        </div>
    </div>

</div>
