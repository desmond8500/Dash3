<div>
    @component('components.layouts.page-header', ['title'=> 'Persona', 'breadcrumbs'=>$breadcrumbs])
    {{-- <button class='btn btn-primary' wire:click="$dispatch('open-addPersona')"><i class='ti ti-plus'></i> Persona</button> --}}
    @endcomponent

    <div class="row">
        <div class="col-md-3">
            @include('_card.persona_card',['persona', $persona])
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Photos</div>
                    <div class="card-actions">
                        <button class="btn btn-primary btn-icon disabled" >
                            <i class="ti ti-plus"></i>
                        </button>
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
