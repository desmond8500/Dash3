<?php

use Livewire\Volt\Component;
use App\Models\Item;
new class extends Component {
    public $name;
    public $description;
    public $search;

    function with() {
        return [
            'list' => $this->get_list(),
        ];
    }

    function store(){
        Item::create([
            'name' => ucfirst($this->name),
            'description' => $this->description,
        ]);
        $this->dispatch('close-addItem');
    }

    public $selected;
    function edit($id){
        $item = Item::find($id);
        $this->selected = $id;
        $this->name = $item->name;
        $this->description = $item->description;
        $this->dispatch('open-editItem');
    }

    function update(){
        $item = Item::find($this->selected);
        $item->name = $this->name;
        $item->description = $this->description;
        $item->save();
        $this->dispatch('close-editItem');
    }

    function delete($id){
        Item::find($id)->delete();
    }

    function get_list(){
        return Item::all();
    }
}; ?>

<div class="row g-2">
    <div class="col">
        <div class="input-icon">
            <input type="text" class="form-control form-control-rounded" wire:model.live="search" placeholder="Chercher un item...">
            <span class="input-icon-addon">
                <i class="ti ti-search"></i>
            </span>
        </div>
    </div>
    <div class="col-auto">
        <button class='btn btn-primary' wire:click="$dispatch('open-addItem')" ><i class='ti ti-plus'></i> Item</button>
    </div>
    <div class="w-100"></div>

    @foreach ($list as $itemo)
        <div class="col-md-6">
            <div class="card p-2">
                <div class="row">
                    <div class="col">
                        <div class="card-title">{{ $itemo->name }}</div>
                        <div class="text-muted">{!! nl2br($itemo->description) !!}</div>
                    </div>
                    <div class="col-auto">
                      <button class="btn btn-outline-primary btn-sm btn-icon" wire:click="edit('{{ $itemo->id }}')">
                        <i class="ti ti-edit"></i>
                      </button>
                      <button class="btn btn-outline-danger btn-sm btn-icon" wire:click="delete('{{ $itemo->id }}')">
                        <i class="ti ti-trash"></i>
                      </button>
                  </div>
                </div>
            </div>
        </div>

    @endforeach


    @component('components.modal', ["id"=>'addItem', 'title' => 'Ajouter un item', 'method'=>'store'])
        <form class="row" wire:submit="store">
            @include('_form.item_form')
        </form>
        <script> window.addEventListener('open-addItem', event => { window.$('#addItem').modal('show'); }) </script>
        <script> window.addEventListener('close-addItem', event => { window.$('#addItem').modal('hide'); }) </script>
    @endcomponent

    @component('components.modal', ["id"=>'editItem', 'title' => 'Editer un item', 'method'=>'update'])
        <form class="row" wire:submit="update">
            @include('_form.item_form')
        </form>
        <script> window.addEventListener('open-editItem', event => { window.$('#editItem').modal('show'); }) </script>
        <script> window.addEventListener('close-editItem', event => { window.$('#editItem').modal('hide'); }) </script>
    @endcomponent
</div>
