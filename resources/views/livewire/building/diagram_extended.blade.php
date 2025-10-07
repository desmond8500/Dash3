<?php

use Livewire\Volt\Component;
use App\Models\BuildingItem;
use App\Models\Stage;

new class extends Component {
    public $building_id;
    public $item_id;
    public $parent_id;
    public $name;
    public $search;

    public function mount($building_id) {
        $this->building_id = $building_id;
    }

    function with() {
        return [
            'building_id' => $this->get_list(),
            'stages' => Stage::where('building_id', $this->building_id)->get(),
            'schemas' => $this->get_schemas(),
        ];
    }

    function get_list(){
        return BuildingItem::all();
    }
    function store(){
        BuildingItem::create([
            'building_id' => $this->building_id,
            'item_id' => $this->item_id,
            'parent_id' => $this->parent_id,
            'name' => ucfirst($this->name),
        ]);
        $this->dispatch('close-addBuildingItem');
    }

    public $selected;

    function edit($id){
        $item = BuildingItem::find($id);
        $this->selected = $id;
        $this->building_id = $item->building_id;
        $this->item_id = $item->item_id;
        $this->parent_id = $item->parent_id;
        $this->name = $item->name;
        $this->dispatch('open-editItem');
    }

    function update(){
        $item = BuildingItem::find($this->selected);
        $item->building_id = $this->building_id;
        $item->item_id = $this->item_id;
        $item->parent_id = $this->parent_id;
        $item->name = $this->name;
        $item->save();
        $this->dispatch('close-editItem');
    }

    function delete($id){
        BuildingItem::find($id)->delete();
    }

    // Schéma
    public $schema_name;
    public $schema_type = 'diagram';
    public $schema_description;
    public $schema_data;
    public $schema_selected;

    function get_schemas(){
        return \App\Models\schema::where('building_id', $this->building_id)->get();
    }

    function set_schema($id){
        $this->schema_selected = \App\Models\schema::find($id);
    }

    function store_schema(){
        \App\Models\schema::create([
            'building_id' => $this->building_id,
            'name' => ucfirst($this->schema_name),
            'type' => $this->schema_type,
            'description' => $this->schema_description,
            'data' => $this->schema_data,
        ]);
        $this->dispatch('close-addSchema');
    }

    function edit_schema($id){
        $schema = \App\Models\schema::find($this->schema_selected->id);
        $this->selected = $id;
        $this->schema_name = $schema->name;
        $this->schema_type = $schema->type;
        $this->schema_description = $schema->description;
        $this->schema_data = $schema->data;
        $this->dispatch('open-editSchema');
    }

    function update_schema(){
        $schema = \App\Models\schema::find($this->schema_selected->id);
        $schema->building_id = $this->building_id;
        $schema->name = ucfirst($this->schema_name);
        $schema->type = $this->schema_type;
        $schema->description = $this->schema_description;
        $schema->data = $this->schema_data;
        $schema->save();
        $this->dispatch('close-editSchema');
    }

    function delete_schema(){
        $schema = \App\Models\schema::find($this->schema_selected->id)->delete();
        $schema->delete();
    }

};
?>

<div>
    <div class="row g-2">
        <div class="col">
            @foreach ($schemas as $schema)
                <button class="btn btn-primary" wire:click="set_schema('{{ $schema->id }}')" >{{ $schema->name }}</button>
            @endforeach

        </div>
        <div class="col-auto">
            <button class="btn btn-primary" wire:click="$dispatch('open-addSchema')">
                <i class="ti ti-plus"></i> Schéma
            </button>
        </div>
    </div>
    <hr>

    {{-- Affichage du schéma --}}
    @if ($schema_selected)
        <div class="row">
            <div class="col-md-12 card p-2 mb-3">
                {{-- Ici le schéma --}}
                {{-- <div>{!! $schema_selected->data !!}</div> --}}
                <div class="d-flex justify-content-between" >
                    <div>
                        <a href="{{  route('schema', ['schema_id'=>$schema_selected->id]) }}" class="fw-bold"> {{ $schema_selected->name }}</div>

                    </div>
                    <div>
                        <button class="btn btn-primary btn-icon btn-sm" >
                            <i class="ti ti-pencil" wire:click="edit_schema('{{ $schema_selected->id }}')"></i>
                        </button>
                        <button class="btn btn-danger btn-icon btn-sm" >
                            <i class="ti ti-trash" wire:click="delete_schema('{{ $schema_selected->id }}')"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        @if ($schema_selected->type == 'rack')
            <div class="row g-1">
                <div class="col-md-12">
                    <div class="card p-2"> 1U</div>
                    <div class="card p-2"> 1U</div>
                    <div class="card p-2"> 1U</div>
                    <div class="card p-2"> 1U</div>
                </div>

            </div>
        @endif
    @endif


    @component('components.modal', ["id"=>'addSchema', 'title' => 'Ajouter un Schéma', 'method'=>'store_schema'])
        <form class="row" wire:submit="store_schema">
            @include('_form.schema_form')
        </form>
        <script> window.addEventListener('open-addSchema', event => { window.$('#addSchema').modal('show'); }) </script>
        <script> window.addEventListener('close-addSchema', event => { window.$('#addSchema').modal('hide'); }) </script>
    @endcomponent
    @component('components.modal', ["id"=>'editSchema', 'title' => 'Ajouter un Schéma', 'method'=>'update_schema'])
        <form class="row" wire:submit="update_schema">
            @include('_form.schema_form')
        </form>
        <script> window.addEventListener('open-editSchema', event => { window.$('#editSchema').modal('show'); }) </script>
        <script> window.addEventListener('close-editSchema', event => { window.$('#editSchema').modal('hide'); }) </script>
    @endcomponent

    @component('components.modal', ["id"=>'addBuildingItem', 'title' => 'Ajouter un diagramme', 'method'=>'store'])
        <form class="row" wire:submit="store">
            @include('_form.item_form')
        </form>
        <script> window.addEventListener('open-addBuildingItem', event => { window.$('#addBuildingItem').modal('show'); }) </script>
        <script> window.addEventListener('close-addBuildingItem', event => { window.$('#addBuildingItem').modal('hide'); }) </script>
    @endcomponent

    @component('components.modal', ["id"=>'editItem', 'title' => 'Ajouter un item', 'method'=>'update'])
        <form class="row" wire:submit="update">
            @include('_form.item_form')
        </form>
        <script> window.addEventListener('open-editItem', event => { window.$('#editItem').modal('show'); }) </script>
        <script> window.addEventListener('close-editItem', event => { window.$('#editItem').modal('hide'); }) </script>
    @endcomponent
</div>





