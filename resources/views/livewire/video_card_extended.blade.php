<?php

use Livewire\Volt\Component;

new class extends Component {
    public $video;

}; ?>

<div>
    <style>
        .v_card_extended {
            display: grid;
            grid-template-columns: 100px 1fr;
        }
    </style>

    <div class="card">
        <a href="{{ route('video',['video_id'=> $video->id]) }}" class="img-responsive img-responsive-16x12 card-img-top"
            style="background-image: url({{ $video->preview_image ?? "img/placeholder/placeholder-video.png" }})"></a>
        <div class="p-2">
            <div class="row">
                <div class="col">
                    <h3 class="card-title">{{ $video->title }}</h3>
                </div>
                <div class="col-auto">
                    <button class="btn btn-action" wire:click="$dispatch('open-editVideo', { video_id: {{ $video->id }} })">
                        <i class="ti ti-edit"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>

