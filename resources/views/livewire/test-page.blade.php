<div>
    @component('components.layouts.page-header', ['title'=> 'Test page'])
        <div class="btn-list">
            <button class="btn btn-icon" wire:click='$refresh'><i class="ti ti-reload"></i> </button>
        </div>
    @endcomponent

    <div class="row mt-3">


        <section class="col-md-8">


            <div id="lightgallery" wire:ignore.self>
                @foreach ($images as $image)
                <a href="{{ asset($image['url']) }}" data-sub-html="{{ $image['title'] }}">
                    <img src="{{ asset($image['url']) }}" alt="{{ $image['title'] }}" style="width: 150px; height: auto;">
                </a>
                @endforeach
            </div>

            @script

            <script>
                document.addEventListener('livewire:load', function () {
                    const gallery = document.getElementById('lightgallery');
                    lightGallery(gallery, {
                        plugins: [],
                        speed: 500,
                    });
                });
            </script>

            @endscript





            <div class="row">
                @foreach ($widgets as $widget)
                @if ($widget->type == "include")
                <a href="{{ $widget->link }}" target="_blank" class="{{ $widget->class }}">
                    @includeWhen($widget->id == $selected_widget, $widget->view )
                </a>
                @elseif($widget->type == "livewire")
                @if ($widget->id == $selected_widget)
                @livewire($widget->view)
                @endif
                @endif
                @endforeach
            </div>
        </section>

        <nav class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Liste des Widgets</div>
                    <div class="card-actions">

                    </div>
                </div>
                <div class="card-body card-body-scrollable card-body-scrollable-shadow" style="height: 600px;">
                    @foreach ($widgets as $widget)
                        <a class="card p-2 mb-1" type="button" wire:click="$set('selected_widget', '{{ $widget->id }}')">
                            <div>
                                @if ($widget->type == 'livewire')
                                    <div class="badge text-white bg-pink">{{ $widget->type }}</div>
                                @else
                                    <div class="badge text-white bg-purple">{{ $widget->type }}</div>
                                @endif
                            </div>

                            <div class="fw-bold">{{ $widget->name }}</div>
                            <div>{!! $widget->description !!}</div>
                            <div class="muted">{{ $widget->view }}</div>
                        </a>
                    @endforeach
                </div>
                <div class="card-footer">

                </div>
            </div>
        </nav>

    </div>



</div>
