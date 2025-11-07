<div>
    @component('components.layouts.page-header', ['title'=> 'Vidéo', 'breadcrumbs'=>$breadcrumbs])
    <div class="btn-list">

        @livewire('video_add_extended', key('video_add_extended'))
    </div>
    @endcomponent

    <div class="row g-2">
        <div class="col-md-7">
            <iframe src="{{ $video->url }}" frameborder="0" width="100%"></iframe>
        </div>
        <div class="col-md-5">
            <h1>Playlist</h1>
        </div>
    </div>


</div>
