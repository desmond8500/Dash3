<?php

use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\MyprojectPhoto;
use App\Models\MyprojectFile;

new class extends Component {
    use WithPagination;
    use WithFileUploads;

    public $project_id;
    public $files;
    public $type;

    function mount($project_id){
        $this->project_id = $project_id;
    }

    public function with()
    {
        return [
            'project' => \App\Models\Myproject::find($this->project_id),
        ];
    }

    function add_files($type){
        $this->type = $type;
        $this->dispatch('open-addProjectFile');
    }

    function store(){
        if($this->type == 'photos'){
            $this->storePhotos();
        } else {
            $this->storeFiles();
        }
        $this->dispatch('close-addProjectFile');
    }
    public $selected_file;
    function edit_file($file_id){
        $file = MyprojectFile::find($file_id);

    }

    function delete_file($file_id){
        $file = MyprojectFile::find($file_id);
        if($file){
            $file->delete();
        }else {
            $file = MyprojectPhoto::find($file_id);
            if($file){
                $file->delete();
            }
        }
    }


    function storePhotos(){
        foreach ($this->files as $key => $file) {
            $dir = "myprojects/$this->project_id/files";
            $name = $file->getClientOriginalName();
            $file->storeAs("public/$dir", $name);

            MyprojectPhoto::create([
                'myproject_id' => $this->project_id,
                'photo_path' => "storage/$dir/$name",
                'caption' => '',
            ]);
        }
    }

    function storeFiles(){
        foreach ($this->files as $key => $file) {
            $dir = "myprojects/$this->project_id/files";
            $name = $file->getClientOriginalName();
            $file->storeAs("public/$dir", $name);

            MyprojectFile::create([
                'myproject_id' => $this->project_id,
                'file_path' => "storage/$dir/$name",
                'description' => '',
            ]);
        }
    }
}; ?>

<div class="row g-2">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Photos - {{ $type }}</div>
                <div class="card-actions">
                    <button class='btn btn-primary' wire:click="add_files('photos')"><i class='ti ti-plus'></i>
                            Photos
                    </button>
                </div>
            </div>
            @if ($project->photos->count())
                <div class="p-2">
                    <div class="row g-2">
                        @foreach($project->photos as $photo)
                            <div class="col-md-2" >
                                <a href="{{ asset($photo->photo_path) }}" class="card p-1 mb-2" data-lightbox="avatarlist">
                                    <img src="{{ asset($photo->photo_path) }}" alt="A" class="img-fluid rounded ">
                                    <div wire:click="delete_file({{ $photo->id }})" style="cursor: pointer; position: absolute; top: 5px; right: 5px; background: rgba(255,255,255,0.7); border-radius: 5px; padding: 1px; z-index: 10;">
                                        <i class="ti ti-x"></i>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Fichiers {{ $type }}</div>
                <div class="card-actions">
                    <button class='btn btn-primary' wire:click="add_files('fichiers')"><i class='ti ti-plus'></i>
                            Fichiers
                    </button>
                </div>
            </div>
            @if ($project->files->count())
                <div class="p-1">
                    @foreach($project->files as $file)
                        <div class="row g-1">
                            <div class="col-auto">
                                <i class="ti ti-file"></i>
                            </div>
                            <div class="col">
                                <a href="{{ asset($file->file_path) }}" target="_blank">{{ $file->description ?? "Nom" }} ret</a>
                            </div>
                            <div class="col-auto" wire:click="delete_file({{ $file->id }})" style="cursor: pointer;">
                                <i class="ti ti-x"></i>
                            </div>

                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        <div class="card mt-2">
            <div class="card-header">
                <div class="card-title">Budget</div>
                <div class="card-actions">
                    <button class="btn btn-primary" disabled>
                        <i class="ti ti-plus"></i> Transaction
                    </button>
                </div>
            </div>
        </div>
        <div class="card mt-2">
            <div class="card-header">
                <div class="card-title">Liens</div>
                <div class="card-actions">
                    <button class="btn btn-primary" disabled>
                        <i class="ti ti-plus"></i> Liens
                    </button>
                </div>
            </div>
        </div>
        <div class="card mt-2">
            <div class="card-header">
                <div class="card-title">Notes</div>
                <div class="card-actions">
                    <button class="btn btn-primary" disabled>
                        <i class="ti ti-plus"></i> Notes
                    </button>
                </div>
            </div>
        </div>
    </div>



    @component('components.modal', ["id"=>'addProjectFile', 'title' => 'Ajouter des fichiers', 'method'=>'store'])
        <form class="row" wire:submit="store">
            @include('_form.project_file_form')
        </form>
        <script> window.addEventListener('open-addProjectFile', event => { window.$('#addProjectFile').modal('show'); }) </script>
        <script> window.addEventListener('close-addProjectFile', event => { window.$('#addProjectFile').modal('hide'); }) </script>
    @endcomponent
</div>
