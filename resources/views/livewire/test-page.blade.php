<div class="row mt-3">
    <div class="col-md-9">
        {{-- <div>
            @livewire('modal')
        </div> --}}

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
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Liste des Widgets</div>
                <div class="card-actions">

                </div>
            </div>
            <div class="card-body">
                <div class="btn-list">
                    @foreach ($widgets as $widget)
                        <a class="btn" wire:click="$set('selected_widget', '{{ $widget->id }}')">{{ $widget->name }}</a>
                    @endforeach
                </div>
            </div>
            <div class="card-footer">

            </div>
        </div>
    </div>

</div>
