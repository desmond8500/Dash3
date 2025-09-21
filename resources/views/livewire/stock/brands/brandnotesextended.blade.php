<?php

use Livewire\Volt\Component;

new class extends Component {

    public $brand_id;

    function mount($brand_id){
        $this->brand_id = $brand_id;
    }

    function with(){
        return [
            'notes' => App\Models\BrandNotes::where('brand_id', $this->brand_id)->get(),
        ];
    }

    public $title;
    public $description;
    public $note_id;
    public $selected_note;

    function show($id){
        $this->selected_note = App\Models\BrandNotes::find($id);

        $this->dispatch('open-showBrandNote');
    }

    function store(){
        App\Models\BrandNotes::create([
            'brand_id' => $this->brand_id,
            'title' => $this->title,
            'description' => $this->description,
        ]);

        $this->dispatch('close-addBrandNote');
    }

    function edit($id){
        $this->note_id = $id;
        $note = App\Models\BrandNotes::find($id);
        if ($note) {
            $this->title = $note->title ;
            $this->description = $note->description ;
        }
        $this->dispatch('open-editBrandNote');
    }

    function update(){
        $note = App\Models\BrandNotes::find($this->note_id);
        if ($note) {
            $note->title = $this->title;
            $note->description = $this->description;
            $note->save();
        }
        $this->dispatch('close-editBrandNote');
    }

    function delete($id){
        $note = \App\Models\BrandNotes::find($id);
        if ($note) {
            $note->delete();
        }
    }
}; ?>

<div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">Notes</div>
            <div class="card-actions">
                <button class='btn btn-primary' wire:click="$dispatch('open-addBrandNote')" ><i class='ti ti-plus'></i> Note</button>
            </div>
        </div>
        <div class="p-2">
            @foreach ($notes as $note)
                <div class="card p-2 mb-1">
                    <div class="row ">
                        <div class="col" wire:click="show('{{ $note->id }}')">
                            {{ $note->title }}
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-primary btn-sm btn-icon" wire:click="edit('{{ $note->id }}')">
                                <i class="ti ti-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm btn-icon" wire:click="delete('{{ $note->id }}')" wire:confirm>
                                <i class="ti ti-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>


    @component('components.modal', ["id"=>'addBrandNote', 'title' => 'Ajouter une note', 'method'=>'store'])
        <form class="row" wire:submit="store">
            @include('_form.brand_note_form')
        </form>
        <script> window.addEventListener('open-addBrandNote', event => { window.$('#addBrandNote').modal('show'); }) </script>
        <script> window.addEventListener('close-addBrandNote', event => { window.$('#addBrandNote').modal('hide'); }) </script>
    @endcomponent

    @component('components.modal', ["id"=>'editBrandNote', 'title' => 'Editer une note', 'method'=>'update'])
        <form class="row" wire:submit="update">
            @include('_form.brand_note_form')
        </form>
        <script> window.addEventListener('open-editBrandNote', event => { window.$('#editBrandNote').modal('show'); }) </script>
        <script> window.addEventListener('close-editBrandNote', event => { window.$('#editBrandNote').modal('hide'); }) </script>
    @endcomponent
    @component('components.modal', ["id"=>'showBrandNote', 'title' => $selected_note->title ?? '' , 'method'=>'update'])
        <form class="row" >
            {!! $selected_note->description ?? '' !!}
        </form>
        <script> window.addEventListener('open-showBrandNote', event => { window.$('#showBrandNote').modal('show'); }) </script>
        <script> window.addEventListener('close-showBrandNote', event => { window.$('#showBrandNote').modal('hide'); }) </script>
    @endcomponent
</div>
