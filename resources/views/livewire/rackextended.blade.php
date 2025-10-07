<?php

use Livewire\Volt\Component;

new class extends Component {
    public $schema_id;
    public $selected;

    protected $listeners = ['get_list'];

    function mount($schema_id) {
        $this->schema_id = $schema_id;
    }

    function with() {
        return [
            'list' => $this->get_list(),
        ];
    }

    function get_list(){
        return \App\Models\SchemaList::where('schema_id', $this->schema_id)->get();
    }

    function edit($id){
        $this->selected = $id;
        $this->dispatch('open-editRack');
    }

    function delete(){
        \App\Models\SchemaList::find($this->selected)->delete();
        $this->dispatch('close-editRack');
        $this->dispatch('get_list');
    }


}; ?>

<div>
    <div class="rack">
        <div class="row">
            @foreach ($list as $item)
                <div class="col-md-12" wire:click="edit('{{ $item->id }}')" >
                    <div class="u">
                        <table>
                            <tr>
                                <td>o</td>
                                <td rowspan="2" style="width: 100%">{{ $item->name }}</td>
                                <td>o</td>
                            </tr>
                            <tr>
                                <td>o</td>
                                <td>o</td>
                            </tr>
                        </table>
                    </div>
                </div>
            @endforeach

        </div>
    </div>

    <style>
        .rack {
            border: 10px solid #000;
            padding: 10px;
            background-color: #e9ecef;
        }
        .circle1{
            position: absolute;
            top: 10px
        }

        .u {
            border: 1px solid #ccc;
            padding: 0px 10px 0px 10px;
            margin-bottom: 5px;
            background-color: #f8f9fa;
        }
    </style>


    @component('components.modal', ["id"=>'editRack', 'title' => 'Editer un rack'])
        <form class="row" >
            {{-- @include('_form.document_form') --}}

            <a class="btn btn-danger btn-icon" wire:click="delete('{{ $this->selected }}')">
                <i class="ti ti-trash"></i>
            </a>
        </form>
        <script> window.addEventListener('open-editRack', event => { window.$('#editRack').modal('show'); }) </script>
        <script> window.addEventListener('close-editRack', event => { window.$('#editRack').modal('hide'); }) </script>
    @endcomponent

</div>
