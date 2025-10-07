<?php

use Livewire\Volt\Component;
use App\Models\Item;

new class extends Component {
    public $schema_id;
    public $selected;
    public $search = '';

    protected $listeners = ['get_list'];

    function mount($schema_id) {
        $this->schema_id = $schema_id;
    }

    function with() {
        return [
            'list' => $this->get_list(),
            "items" => Item::search($this->search)->paginate(10),

        ];
    }

    function get_list(){
        return \App\Models\SchemaList::where('schema_id', $this->schema_id)->get();
    }

    function action($item_id){
        $this->selected = Item::find($item_id);
        $this->dispatch('open-addLinkedItem');
    }

    function add_item($item_id){
        $schema = Schema::find($this->schema_id);
        $item = Item::find($item_id);

        SchemaList::create([
            'item_id' => $item->id,
            'parent_id' => $this->selected->id,
            'name' => $item->name,
        ]);
        $this->dispatch('get_list');
        $this->dispatch('close-addLinkedItem');
    }

}; ?>

<div>
    @foreach ($list as $item)
        <div class="card p-3 mb-2">
            <div>
                <button class="btn btn-primary" wire:click="action('{{ $item->id }}')">{{ $item->name }}</button>
            </div>
            <div>
                @foreach ($item->children as $child)
                    <div class="card p-2 mt-2">
                        {{ $child->name }}
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach

    @component('components.modal', ["id"=>'addLinkedItem', 'title' => 'Ajouter un article'])
        <form class="row" >
            <div class="col-md-12">
                <div class="input-icon mb-3">
                    <input type="text" class="form-control form-control-rounded" wire:model.live="search"
                        placeholder="Chercher un article">
                    <span class="input-icon-addon">
                        <i class="ti ti-search"></i>
                    </span>
                </div>
            </div>

            <div>{{ $selected->id }}</div>

            @foreach ($items as $item)
                <div class="col-md-12">
                    <div class="card p-2 mb-1" wire:click="add_item('{{ $item->id }}')" style="cursor: pointer;">
                        {{ $item->name }}
                    </div>
                </div>
            @endforeach
            <div>
                {{ $items->links() }}
            </div>

        </form>
        <script> window.addEventListener('open-addLinkedItem', event => { window.$('#addLinkedItem').modal('show'); }) </script>
        <script> window.addEventListener('close-addLinkedItem', event => { window.$('#addLinkedItem').modal('hide'); }) </script>
    @endcomponent
</div>
