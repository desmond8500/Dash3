<?php

use Livewire\Volt\Component;
use App\Models\ProjectDoc;
use App\Livewire\Forms\ProjectDocForm;
use Livewire\WithPagination;
use Livewire\WithFileUploads;


new class extends Component {
    use WithPagination;
    use WithFileUploads;
    public $projet_id;
    public $search = '';
    public ProjectDocForm $form;

    public function mount($projet_id)
    {
        $this->projet_id = $projet_id;
        $this->form->projet_id = $projet_id;
    }

    function with(){
        return [
            'documents' => ProjectDoc::where('projet_id', $this->projet_id)->paginate(5),
        ];
    }

    function store(){
        $this->form->store();
        $this->dispatch('close-addProjectDocument');
    }
    function delete($id){
        $this->form->set($id);
        $this->form->delete();
    }
}; ?>

<div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">Documents</div>
            <div class="card-actions">
                <div class="input-group">

                    <input type="text" class="form-control" placeholder="Search..." wire:model="search">
                    <button class='btn btn-primary' wire:click="$dispatch('open-addProjectDocument')">
                        <i class='ti ti-plus'></i>
                        Document
                    </button>
                </div>
            </div>
        </div>
        <table class="table table-hover">
            <thead class="sticky-top">
                <tr>
                    <td>#</td>
                    <td>Document</td>
                    <td>Building</td>
                    <td>Actions</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($documents as $key => $document)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>
                        <a href="{{ asset($document->document_path) }}" target="_blank">
                            {{ $document->document_name }}
                        </a>
                    </td>
                    <td>Général</td>
                    <td>
                        <button class="btn btn-primary" wire:click="editDocument({{ $document->id }})">
                            Editer

                        </button>
                        <button class="btn btn-sm btn-danger" wire:click="deleteDocument({{ $document->id }})">
                            Delete
                        </button>

                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="card-footer">
            {{ $documents->links() }}
        </div>
    </div>



    @component('components.modal', ["id"=>'addProjectDocument', 'title' => 'Ajouter un document', 'method'=>'store'])
        <form class="row" wire:submit="store">
            @include('_form.project_doc_form')
        </form>
        <script> window.addEventListener('open-addProjectDocument', event => { window.$('#addProjectDocument').modal('show'); }) </script>
        <script> window.addEventListener('close-addProjectDocument', event => { window.$('#addProjectDocument').modal('hide'); }) </script>
    @endcomponent
</div>
