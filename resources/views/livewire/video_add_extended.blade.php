<?php

use Livewire\Volt\Component;
use App\Livewire\Forms\VideoForm;
use Livewire\WithFileUploads;

new class extends Component {
    use WithFileUploads;
    public VideoForm $video_form;

    public function store()
    {
        $this->video_form->store();

        $this->dispatch('close-addVideo');
        $this->dispatch('get-videos');
    }
}; ?>

<div>
    <button class='btn btn-primary' wire:click="$dispatch('open-addVideo')" ><i class='ti ti-plus'></i> Vidéo</button>

    @component('components.modal', ["id"=>'addVideo', 'title' => 'Ajouter une Vidéo', 'method'=>'store'])
        <form class="row" wire:submit="store">
            @include('_form.video_form')
        </form>
        <script> window.addEventListener('open-addVideo', event => { window.$('#addVideo').modal('show'); }) </script>
        <script> window.addEventListener('close-addVideo', event => { window.$('#addVideo').modal('hide'); }) </script>
    @endcomponent
</div>
