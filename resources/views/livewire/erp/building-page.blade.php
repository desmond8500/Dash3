
<div>
    @component('components.layouts.page-header', ['title'=>'Gestion de batiment', 'breadcrumbs'=>$breadcrumbs])
        <div class="btn-list">
            @if ($selected_tab==1)
                @livewire('form.stage-add', ['building_id' => $building->id], key($building->id))
            @elseif ($selected_tab==2)
                @livewire('form.quantitatif-add', ['building_id' => $building->id], key($building->id))
            @elseif($selected_tab==3)
                @livewire('form.fiche-add', ['building_id' => $building->id])
            @endif
                @livewire('form.task-add', ['building_id' => $building->id])

            <a href="{{ route('avancements',['building_id'=>$building->id]) }}" class="btn btn-primary" >Avancements</a>
            <button class="btn btn-icon" wire:click='$refresh'><i class="ti ti-reload"></i> </button>
        </div>
    @endcomponent

    <div class="row g-2">
        <div class="col-md-12">
            <div class="btn-list">
                @foreach ($tabs as $tab)
                    <button class="btn {{ $tab->number == $selected_tab ? 'btn-primary' : '' }}" wire:click="$set('selected_tab','{{ $tab->number }}')">{{ $tab->name }}</button>
                @endforeach
            </div>
        </div>


        @if ($selected_tab == 0)
            <div>Résumé</div>
            @livewire('erp.building-resumes',['building_id'=> $building->id ])
        @elseif($selected_tab == 1)
            @livewire('erp.stagelist', ['building_id' => $building->id])
        @elseif($selected_tab == 2)
            @livewire('erp.building-quantitatif',['building_id'=> $building->id ])
        @elseif($selected_tab == 3)
            @livewire('erp.building-fiche',['building_id'=> $building->id ])
        @elseif($selected_tab == 4)
            @livewire('erp.building-document',['building_id'=> $building->id ])
        @endif

    </div>

    @component('components.modal', ["id"=>'editBuilding', 'title' => 'Editer un batiment', 'method'=>'update_building'])
        <form class="row" wire:submit="update_building">
            @include('_form.building_form')

        </form>
        <script> window.addEventListener('open-editBuilding', event => { window.$('#editBuilding').modal('show'); }) </script>
        <script> window.addEventListener('close-editBuilding', event => { window.$('#editBuilding').modal('hide'); }) </script>
    @endcomponent

    @component('components.modal', ["id"=>'editStage', 'title' => 'Editer un niveau', 'method'=>'update_stage'])
        <form class="row" wire:submit="update_stage">
            @include('_form.stage_form')
        </form>
        <script> window.addEventListener('open-editStage', event => { window.$('#editStage').modal('show'); }) </script>
        <script> window.addEventListener('close-editStage', event => { window.$('#editStage').modal('hide'); }) </script>
    @endcomponent
</div>
