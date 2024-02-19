<div class="row">
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
