<div>
    @component('components.layouts.page-header', ['title'=> 'Vidéos', 'breadcrumbs'=>$breadcrumbs])
        <div class="btn-list">
            <div class="input-icon">
                <input type="text" class="form-control form-control-rounded" wire:model.live="search" placeholder="Chercher ">
                <span class="input-icon-addon">
                    <i class="ti ti-search"></i>
                </span>
            </div>
            @livewire('video_add_extended', key('video_add_extended'))
        </div>
    @endcomponent
   <style>

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        .video-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .video {
            background: #000;
            border-radius: 10px;
            overflow: hidden;
            aspect-ratio: 16 / 9;
        }

        .video iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
    </style>
    <div class="row">
        <div class="col-md-8">

            <div class="row g-2">
                @foreach($videos as $video)
                    <div  class="col-md-4">
                        @livewire('video_card_extended', ['video' => $video], key("video_card_extended_$video->id"))
                    </div>
                @endforeach
            </div>

        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Playlist</div>
                    <div class="card-actions">

                    </div>
                </div>
                <div class="card-body">

                </div>
                <div class="card-footer">

                </div>
            </div>
        </div>
    </div>

    @component('components.modal', ["id"=>'editVideo', 'title' => 'Editer une Vidéo', 'method'=>'update'])
        <form class="row" wire:submit="update">
            @include('_form.video_form')
        </form>
        <script> window.addEventListener('open-editVideo', event => { window.$('#editVideo').modal('show'); }) </script>
        <script> window.addEventListener('close-editVideo', event => { window.$('#editVideo').modal('hide'); }) </script>
    @endcomponent
</div>
