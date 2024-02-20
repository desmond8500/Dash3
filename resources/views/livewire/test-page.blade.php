<div class="row mt-4">
    <div class="col-md-4">
        <div class="card p-1 bg-light rounded  border-primary">
            <div class="bg-primary p-2 rounded">
                <div class="row ">
                    <div class="col-auto">
                        <img src="" alt="C" class="avatar">
                    </div>
                    <div class="col text-white">
                        <div class="">Client</div>
                        <div class="fw-bold">Charles Dickens</div>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-light btn-icon"><i class="ti ti-edit"></i></button>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between p-2">
                <div> <i class="ti ti-box"></i> Projets <b>83</b></div>
                <div> <i class="ti ti-box"></i> Taches <b>06</b></div>
            </div>

        </div>
    </div>
    <div class="col-md-4">
        <div class="row" >

            @parsedown('#Hello _Parsedown_!')
            @parsedown('Hello _Parsedown_!')


            <button class="btn btn-primary" wire:click='download'>Télécharger</button>
        </div>

    </div>
    <div class="col-md-4">

    </div>

    <div class="col-md-12 mt-5">
        @include('excel.clients_table')
    </div>


</div>
